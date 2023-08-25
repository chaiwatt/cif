<?php

namespace App\Http\Controllers\SalarySystem;

use Carbon\Carbon;
use App\Models\User;
use App\Models\PaydayDetail;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Helpers\AddDefaultWorkScheduleAssignment;
use App\Services\UpdatedRoleGroupCollectionService;

class SalarySystemSalaryCalculationController extends Controller
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
        $users = User::paginate(50);

        $date = Carbon::now();
        $monthId = intval(Carbon::now()->month);
        $currentDate = $date->format('Y-m-d');
        $paydayDetails = PaydayDetail::where('month_id', $monthId)
            ->whereDate('end_date', '<=', Carbon::parse($currentDate))
            ->whereDate('payment_date', '>=', Carbon::parse($currentDate))
            ->get();
        
        if (count($paydayDetails) === 0)   
        {
            return redirect()->route('groups.time-recording-system.schedulework.time-recording')
            ->withErrors(['error_out_payday_range' => __('validation.error_specific')]);
        }

        $userIds = [];
        foreach($paydayDetails as $paydayDetail)
        { 
            $startDate = $paydayDetail->start_date;
            $endDate = $paydayDetail->end_date;
            $ids = $this->getUsersByWorkScheduleAssignment($startDate, $endDate)->pluck('id')->toArray();
            $userIds = array_merge($userIds, $ids);
        }  
        $userIds = array_unique($userIds);

        $users = User::whereIn('id', $userIds)->paginate(20);

        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'users' => $users,
            'paydayDetails' => $paydayDetails
        ]);
    }
    public function getUsersByWorkScheduleAssignment($startDate,$endDate)
    {
        // Convert the start and end date to the correct format
        $startDate = date('Y-m-d', strtotime($startDate));
        $endDate = date('Y-m-d', strtotime($endDate));

        // ค้นหาผู้ใช้ที่มีการกำหนดงานเรียกงานใน workScheduleId และ date_in อยู่ในช่วง startDate ถึง endDate
        $users = User::whereHas('workScheduleAssignmentUsers', function ($query) use ($startDate, $endDate) {
            $query->whereNotNull('date_in')
                ->whereBetween('date_in', [$startDate, $endDate]);
        })->get();

        return $users;

    }
}
