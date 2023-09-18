<?php

namespace App\Http\Controllers\SalarySystem;

use App\Models\Payday;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Helpers\AddDefaultWorkScheduleAssignment;
use App\Services\UpdatedRoleGroupCollectionService;

class SalarySystemSalaryCalculationListController extends Controller
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
    public function index()
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
        $payDays = Payday::all();
        $distinctYears = Payday::distinct('year')->pluck('year');

        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'paydays' => $payDays,
            'years' => $distinctYears,
        ]);
    }
}
