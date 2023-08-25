<?php

namespace App\Http\Controllers\SalarySystem;

use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Helpers\AddDefaultWorkScheduleAssignment;
use App\Models\DiligenceAllowance;
use App\Models\DiligenceAllowanceClassify;
use App\Services\UpdatedRoleGroupCollectionService;

class SalarySystemSettingDiligenceAllowanceAssignmentController extends Controller
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
    public function index($id)
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'show'
        $action = 'show';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission, viewName โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $viewName = $roleGroupCollection['viewName'];
        $diligenceAllowance = DiligenceAllowance::find($id);
        $diligenceAllowanceClassifies = DiligenceAllowanceClassify::where('diligence_allowance_id',$id)->get();


        return view('groups.salary-system.setting.diligence-allowance.assignment.index', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'diligenceAllowance' => $diligenceAllowance,
            'diligenceAllowanceClassifies' => $diligenceAllowanceClassifies,
        ]);
    }
}
