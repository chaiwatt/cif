<?php

namespace App\Http\Controllers\SalarySystem;

use App\Models\User;
use App\Models\PaydayDetail;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\WorkScheduleAssignmentUser;
use App\Helpers\AddDefaultWorkScheduleAssignment;
use App\Services\UpdatedRoleGroupCollectionService;

class SalarySystemSalaryCalculationExtraListCalculationInformationController extends Controller
{
    private $updatedRoleGroupCollectionService;
    private $addDefaultWorkScheduleAssignment;
    private $activityLogger;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService, AddDefaultWorkScheduleAssignment $addDefaultWorkScheduleAssignment,ActivityLogger $activityLogger) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
        $this->addDefaultWorkScheduleAssignment = $addDefaultWorkScheduleAssignment;
        $this->activityLogger = $activityLogger;
    }
    public function index($startDate,$endDate,$userId,$paydayDetailId)
    {
        
        // กำหนดค่าตัวแปร $action ให้เป็น 'show'
        $action = 'show';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission, viewName โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        

        $workScheduleAssignmentUsers = WorkScheduleAssignmentUser::where('user_id', $userId)
                    ->whereBetween('date_in', [$startDate, $endDate])
                    ->orderBy('date_in')
                    ->get();

        $user = User::find($userId);
        $paydayDetail = PaydayDetail::find($paydayDetailId);
        return view('groups.salary-system.salary.calculation-list.calculation.information.index', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'workScheduleAssignmentUsers' => $workScheduleAssignmentUsers,
            'user' => $user,
            'paydayDetail' => $paydayDetail,
        ]);
    }
}
