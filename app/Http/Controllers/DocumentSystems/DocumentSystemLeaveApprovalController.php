<?php

namespace App\Http\Controllers\DocumentSystems;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Leave;
use App\Models\Month;
use App\Models\Approver;
use App\Models\UserLeave;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Models\CompanyDepartment;
use App\Http\Controllers\Controller;
use App\Services\UpdatedRoleGroupCollectionService;

class DocumentSystemLeaveApprovalController extends Controller
{
    private $updatedRoleGroupCollectionService;
    private $activityLogger;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService,ActivityLogger $activityLogger) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
        $this->activityLogger = $activityLogger;
    }
    public function index()
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'show'
        $action = 'show';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $viewName = $roleGroupCollection['viewName'];
        $companyDepartments = CompanyDepartment::all();
        
        $currentMonth = Carbon::today()->month;

        $leaves = Leave::where(function ($query) use ($currentMonth) {
            $query->whereMonth('from_date', $currentMonth)
                ->orWhereMonth('to_date', $currentMonth);
        })->get();

        $months = Month::all();

        $currentYear = Carbon::now()->year;
        $nextYear = $currentYear + 1;
        $years = collect([$currentYear, $nextYear]);

        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'companyDepartments' => $companyDepartments,
            'leaves' => $leaves,
            'months' => $months,
            'years' => $years
        ]);
    }

    public function leaveApproval(Request $request)
    {
        $userId = $request->data['userId'];
        $leaveId = $request->data['leaveId'];
        $value = $request->data['value'];
        $approverId = $request->data['approverId'];
        $approver = Approver::find($approverId);

        $year = $request->data['year'];
        $month = $request->data['month'];
        $searchString = $request->data['searchString'];

        $authId = auth()->user()->id;
        $authorizedUserIds =$approver->authorizedUsers->pluck('id')->toArray();

        $leave = Leave::find($leaveId);
        $approvedList = json_decode($leave->approved_list, true);
        if ($approver->user_id == $authId){
            $leave->update(['manager_approve' => $value ]);
            $atLeastOneStatusIsOne = collect($approvedList)->pluck('status')->some(function ($status) {
                return $status == 1;
            });
   
            $hasStatusTwo = collect($approvedList)->pluck('status')->contains(2);
            if ($atLeastOneStatusIsOne) {
                $leave = Leave::find($leaveId);
                $duration = $leave->duration;
                $leaveTypeId = $leave->leave_type_id;
                $userLeave = UserLeave::where('user_id',$userId)->where('leave_type_id',$leaveTypeId)->first();
                $leaveCount = $userLeave->count - $duration;
                $leave = Leave::find($leaveId);
                if($leave->status != 1 && $leave->manager_approve == 1)
                {
                    UserLeave::where('user_id',$userId)->where('leave_type_id',$leaveTypeId)->first()->update(['count' => $leaveCount]);
                    $leave->update(['status' => 1]);
                }

            } elseif ($hasStatusTwo) {
                $leave->update(['status' => 2]);
            }  
        }
        // 
        $leave = Leave::find($leaveId);

        if (!in_array($authId, $authorizedUserIds) && $approver->user_id != $authId) {
            return response()->json(['error' => 'คุณไม่ได้รับอนุญาติให้ทำรายการ']);
        }

    
        

        $userIndex = null;
        foreach ($approvedList as $index => $item) {
            if ($item['user_id'] === $authId) {
                $userIndex = $index;
                break;
            }
        }

        if ($userIndex !== null) {
            $approvedList[$userIndex]['status'] = $value;
            $updatedApprovedList = json_encode($approvedList);

            $leave->update(['approved_list' => $updatedApprovedList]);

            $atLeastOneStatusIsOne = collect($approvedList)->pluck('status')->some(function ($status) {
                return $status == 1;
            });

            $hasStatusTwo = collect($approvedList)->pluck('status')->contains(2);
            
            if ($atLeastOneStatusIsOne) {
                // Update the status field of the Leave model to 1
                $leave = Leave::find($leaveId);
                $duration = $leave->duration;
                $leaveTypeId = $leave->leave_type_id;
                $userLeave = UserLeave::where('user_id',$userId)->where('leave_type_id',$leaveTypeId)->first();
                $leaveCount = $userLeave->count - $duration;
                $leave = Leave::find($leaveId);
                if($leave->status != 1 && $leave->manager_approve == 1)
                {
                    
                    UserLeave::where('user_id',$userId)->where('leave_type_id',$leaveTypeId)->first()->update(['count' => $leaveCount]);
                    $leave->update(['status' => 1]);
                }
                
            
            } elseif ($hasStatusTwo) {
                // Update the status field of the Leave model to 2
                $leave->update(['status' => 2]);
            }

        } 

        if (isset($request->data['selectedCompanyDepartment'])) {
            $companyDepartmentIds = $request->data['selectedCompanyDepartment'];
        } else {
            $companyDepartmentIds = [];
        }

        $query = Leave::whereHas('user', function ($query) use ($searchString,$companyDepartmentIds) {
            $query->where(function ($query) use ($searchString) {
                $query->where('employee_no', 'like', '%' . $searchString . '%')
                    ->orWhere('name', 'like', '%' . $searchString . '%')
                    ->orWhere('lastname', 'like', '%' . $searchString . '%')
                    ->orWhereHas('approvers', function ($subQuery) use ($searchString) {
                        $subQuery->where('name', 'like', '%' . $searchString . '%')
                        ->orWhere('code', 'like', '%' . $searchString . '%');
                    });
            });
            if (!empty($companyDepartmentIds)) {
                $query->whereHas('company_department', function ($subQuery) use ($companyDepartmentIds) {
                    $subQuery->whereIn('id', $companyDepartmentIds);
                });
            }
        })
        ->whereYear('from_date', $year)
        ->whereMonth('from_date', $month);

        $leaves = $query->get();

        return view('groups.document-system.leave.approval.table-render.leave-table-render',[
            'leaves' => $leaves
            ])->render();
    }

    public function search(Request $request)
    {
        if (isset($request->data['selectedCompanyDepartment'])) {
            $companyDepartmentIds = $request->data['selectedCompanyDepartment'];
        } else {
            $companyDepartmentIds = [];
        }

        $year = $request->data['year'];
        $month = $request->data['month'];
        $searchString = $request->data['searchString'];

        $query = Leave::whereHas('user', function ($query) use ($searchString,$companyDepartmentIds) {
            $query->where(function ($query) use ($searchString) {
                $query->where('employee_no', 'like', '%' . $searchString . '%')
                    ->orWhere('name', 'like', '%' . $searchString . '%')
                    ->orWhere('lastname', 'like', '%' . $searchString . '%')
                    ->orWhereHas('approvers', function ($subQuery) use ($searchString) {
                        $subQuery->where('name', 'like', '%' . $searchString . '%')
                        ->orWhere('code', 'like', '%' . $searchString . '%');
                    });
            });
            if (!empty($companyDepartmentIds)) {
                $query->whereHas('company_department', function ($subQuery) use ($companyDepartmentIds) {
                    $subQuery->whereIn('id', $companyDepartmentIds);
                });
            }
        })
        ->whereYear('from_date', $year)
        ->whereMonth('from_date', $month);

        $leaves = $query->get();

        return view('groups.document-system.leave.approval.table-render.leave-table-render',[
            'leaves' => $leaves
            ])->render();
    }

}
