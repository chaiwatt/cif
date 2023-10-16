<?php

namespace App\Http\Controllers\DocumentSystems;

use Carbon\Carbon;
use App\Models\Month;
use App\Models\Approver;
use App\Models\OverTime;
use Illuminate\Http\Request;
use App\Models\OverTimeDetail;
use App\Helpers\ActivityLogger;
use App\Models\CompanyDepartment;
use App\Http\Controllers\Controller;
use App\Services\UpdatedRoleGroupCollectionService;

class DocumentSystemOvertimeApprovalController extends Controller
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
        
        // Get the current date
        $currentDate = Carbon::today()->format('Y-m-d');

        // Retrieve Leave records with from_date equal to or greater than today
        // $leaves = Leave::where('from_date', '>=', $currentDate)->paginate(2);
        $overtimeDetails = OverTimeDetail::get();
        $months = Month::all();

        $currentYear = Carbon::now()->year;
        $nextYear = $currentYear + 1;
        $years = collect([$currentYear, $nextYear]);

        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'companyDepartments' => $companyDepartments,
            'overtimeDetails' => $overtimeDetails,
            'months' => $months,
            'years' => $years
        ]);
    }


    public function overTimeApproval(Request $request)
    {
        // $userId = $request->data['userId'];
        $overtimeId = $request->data['overtimeId'];
        $value = $request->data['value'];
        $approverId = $request->data['approverId'];

        // $month = $request->data['month'];
        // $year = $request->data['year'];

        $overtime = Overtime::find($overtimeId);
        $approver = $overtime->approver;


       
        $date = Carbon::parse($overtime->from_date);
        $year = $date->year;
        $month = $date->month;


        $authId = auth()->user()->id;


        $approvedList = json_decode($overtime->approved_list, true);
        $authorizedUserIds =$approver->authorizedUsers->pluck('id')->toArray();
        
        if ($approver->user_id == $authId){
            $overtime->update(['manager_approve' => $value ]);
            $atLeastOneStatusIsOne = collect($approvedList)->pluck('status')->some(function ($status) {
                return $status == 1;
            });
            
            $hasStatusTwo = collect($approvedList)->pluck('status')->contains(2);
            if ($atLeastOneStatusIsOne) {
                $overtime = Overtime::find($overtimeId);
                if($overtime->status != 1 && $overtime->manager_approve == 1)
                { 
                    $overtime->update(['status' => 1]);
                }

                // dd($overtime->name,$approver->user->name,$approvedList,$value,$atLeastOneStatusIsOne );

            } elseif ($hasStatusTwo) {
                $overtime->update(['status' => 2]);
            }  
        }

        if (!in_array($authId, $authorizedUserIds) && $approver->user_id != $authId) {
            return response()->json(['error' => 'คุณไม่ได้รับอนุญาติให้ทำรายการ']);
        }

        $userIndex = null;
        foreach ($approvedList as $index => $item) {
            if ($item['user_id'] == $authId) {
                $userIndex = $index;
                break;
            }
        }

       

        if ($userIndex !== null) {
            $approvedList[$userIndex]['status'] = $value;
            $updatedApprovedList = json_encode($approvedList);
            

            $overtime->update(['approved_list' => $updatedApprovedList]);

            $atLeastOneStatusIsOne = collect($approvedList)->pluck('status')->some(function ($status) {
                return $status == 1;
            });

            $hasStatusTwo = collect($approvedList)->pluck('status')->contains(2);
            if ($atLeastOneStatusIsOne) {
                $overtime = OverTime::find($overtimeId);
                if($overtime->status != 1 && $overtime->manager_approve == 1)
                {
                    $overtime->update(['status' => 1]);
                }
            
            } elseif ($hasStatusTwo) {
                // Update the status field of the Leave model to 2
                $overtime->update(['status' => 2]);
            }
        }
       
        $overtimes = Overtime::whereMonth('from_date',$month)->whereYear('from_date',$year)->get();

        return view('groups.document-system.overtime.approval.table-render.overtime-approval-table-render',[
            'overtimes' => $overtimes
            ])->render();


        // $authorizedUserIds =$approver->authorizedUsers->pluck('id')->toArray();

        // if (!in_array($authId, $authorizedUserIds)) {
        //     return response()->json(['error' => 'คุณไม่ได้รับอนุญาติให้ทำรายการ']);
        // }

        // $overtimeDetail = OverTimeDetail::find($overtimeId);

        // $approvedList = json_decode($overtimeDetail->approved_list, true);

        // $userIndex = null;
        // foreach ($approvedList as $index => $item) {
        //     if ($item['user_id'] === $authId) {
        //         $userIndex = $index;
        //         break;
        //     }
        // }
        
        // if ($userIndex !== null) {
        //     $approvedList[$userIndex]['status'] = $value;
        //     $updatedApprovedList = json_encode($approvedList);
        //     $overtimeDetail->update(['approved_list' => $updatedApprovedList]);
        //     $allStatusesAreOne = collect($approvedList)->pluck('status')->every(function ($status) {
        //         return $status == 1;
        //     });

        //     $hasStatusTwo = collect($approvedList)->pluck('status')->contains(2);

        //     if ($allStatusesAreOne) {
        //         $overtimeDetail->update(['status' => 1]);
        //     } elseif ($hasStatusTwo) {
        //         $overtimeDetail->update(['status' => 2]);
        //     } else {
        //         $overtimeDetail->update(['status' => 0]);
        //     }

        // } 

        // if (isset($request->data['selectedCompanyDepartment'])) {
        //     $companyDepartmentIds = $request->data['selectedCompanyDepartment'];
        // } else {
        //     $companyDepartmentIds = [];
        // }
   
        // $startDate = null;
        // $endDate = null;

        // if ($request->data['startDate'] !== null && $request->data['endDate'] !== null) {
        //     $startDate = date('Y-m-d', strtotime($request->data['startDate']));
        //     $endDate = date('Y-m-d', strtotime($request->data['endDate']));
        // }

        // $searchString = $request->data['searchString'];

        // $query = OverTimeDetail::whereHas('user', function ($query) use ($searchString, $companyDepartmentIds) {
        //     $query->where(function ($query) use ($searchString) {
        //         $query->where('employee_no', 'like', '%' . $searchString . '%')
        //             ->orWhere('name', 'like', '%' . $searchString . '%')
        //             ->orWhere('lastname', 'like', '%' . $searchString . '%')
        //             ->orWhereHas('approvers', function ($subQuery) use ($searchString) {
        //                 $subQuery->where('name', 'like', '%' . $searchString . '%')
        //                     ->orWhere('code', 'like', '%' . $searchString . '%');
        //             });
        //     });
        //     if (!empty($companyDepartmentIds)) {
        //         $query->whereHas('company_department', function ($subQuery) use ($companyDepartmentIds) {
        //             $subQuery->whereIn('id', $companyDepartmentIds);
        //         });
        //     }
        // });

        // if ($startDate !== null && $endDate !== null) {
        //     $query->whereBetween('from_date', [$startDate, $endDate]);
        // }

        // $overtimeDetails = $query->get();

        // return view('groups.document-system.overtime.approval.table-render.overtime-approval-table-render',[
        //     'overtimeDetails' => $overtimeDetails
        //     ])->render();
    }


    public function search(Request $request)
    {
        $month = $request->data['month'];
        $year = $request->data['year'];
       
        $overtimes = Overtime::whereMonth('from_date',$month)->whereYear('from_date',$year)->get();

        //  dd($month,$year,$overtimes);
        return view('groups.document-system.overtime.approval.table-render.overtime-approval-table-render',[
            'overtimes' => $overtimes
            ])->render();
        // if (isset($request->data['selectedCompanyDepartment'])) {
        //     $companyDepartmentIds = $request->data['selectedCompanyDepartment'];
        // } else {
        //     $companyDepartmentIds = [];
        // }
   
        // $startDate = null;
        // $endDate = null;

        // if ($request->data['startDate'] !== null && $request->data['endDate'] !== null) {
        //     $startDate = date('Y-m-d', strtotime($request->data['startDate']));
        //     $endDate = date('Y-m-d', strtotime($request->data['endDate']));
        // }

        // $searchString = $request->data['searchString'];

        // $query = OverTimeDetail::whereHas('user', function ($query) use ($searchString, $companyDepartmentIds) {
        //     $query->where(function ($query) use ($searchString) {
        //         $query->where('employee_no', 'like', '%' . $searchString . '%')
        //             ->orWhere('name', 'like', '%' . $searchString . '%')
        //             ->orWhere('lastname', 'like', '%' . $searchString . '%')
        //             ->orWhereHas('approvers', function ($subQuery) use ($searchString) {
        //                 $subQuery->where('name', 'like', '%' . $searchString . '%')
        //                     ->orWhere('code', 'like', '%' . $searchString . '%');
        //             });
        //     });
        //     if (!empty($companyDepartmentIds)) {
        //         $query->whereHas('company_department', function ($subQuery) use ($companyDepartmentIds) {
        //             $subQuery->whereIn('id', $companyDepartmentIds);
        //         });
        //     }
        // });

        // if ($startDate !== null && $endDate !== null) {
        //     $query->whereBetween('from_date', [$startDate, $endDate]);
        // }

        // $overtimeDetails = $query->get();


        // return view('groups.document-system.overtime.approval.table-render.overtime-approval-table-render',[
        //     'overtimeDetails' => $overtimeDetails
        //     ])->render();
    }
}
