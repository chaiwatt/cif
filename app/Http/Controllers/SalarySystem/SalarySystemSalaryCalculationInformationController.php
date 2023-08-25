<?php

namespace App\Http\Controllers\SalarySystem;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\WorkScheduleAssignmentUser;
use App\Helpers\AddDefaultWorkScheduleAssignment;
use App\Services\UpdatedRoleGroupCollectionService;

class SalarySystemSalaryCalculationInformationController extends Controller
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
    public function index($startDate,$endDate,$userId)
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
                    ->get();

        $user = User::find($userId);
        return view('groups.salary-system.salary.calculation.information.index', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'workScheduleAssignmentUsers' => $workScheduleAssignmentUsers,
            'user' => $user
        ]);
        // foreach($workScheduleAssignmentUsers as $workScheduleAssignmentUser)
        // {
        //     $dateTimeIn = $workScheduleAssignmentUser->date_in . ' ' . $workScheduleAssignmentUser->time_in;
        //     $dateTimeOut = $workScheduleAssignmentUser->date_out . ' ' . $workScheduleAssignmentUser->time_out;
        //     $shift = $workScheduleAssignmentUser->workScheduleAssignment->shift;
        //     echo($dateTimeIn . ' ' . $dateTimeOut . ' <br>');
        //     // echo($shift->start . ' ' . $shift->end . ' <br>');
        // }
    }
}
