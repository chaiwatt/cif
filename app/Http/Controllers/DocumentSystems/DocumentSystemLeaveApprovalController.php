<?php

namespace App\Http\Controllers\DocumentSystems;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Leave;
use App\Models\Month;
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
        
        // Get the current date
        $currentDate = Carbon::today()->format('Y-m-d');

        // Retrieve Leave records with from_date equal to or greater than today
        // $leaves = Leave::where('from_date', '>=', $currentDate)->get();
        $leaves = Leave::all();
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

        $user = User::find($userId);
        
        $uniqueApproverOneIds = $user->unique_approver_one_ids;
        $uniqueApproverTwoIds = $user->unique_approver_two_ids;

        $authenticatedUserId = auth()->user()->id;
        if (!in_array($authenticatedUserId, $uniqueApproverOneIds) && !in_array($authenticatedUserId, $uniqueApproverTwoIds)) {
            return response()->json(['error' => 'คุณไม่ได้รับอนุญาติให้ทำรายการ']);
        }

        Leave::find($leaveId)->update([
            'status' => $value
        ]);

        // $leaves = Leave::where('from_date', '>=', $currentDate)->get();
        $leaves = Leave::all();

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
                    ->orWhere('passport', 'like', '%' . $searchString . '%')
                    ->orWhere('hid', 'like', '%' . $searchString . '%');
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
