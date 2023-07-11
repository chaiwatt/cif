<?php

namespace App\Http\Controllers\TimeRecordingSystems;

use Carbon\Carbon;
use App\Models\Month;
use App\Models\WorkSchedule;
use App\Http\Controllers\Controller;
use App\Services\UpdatedRoleGroupCollectionService;

class TimeRecordingSystemScheduleWorkTimeRecordingController extends Controller
{
    private $updatedRoleGroupCollectionService;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
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

        // ค้นหาปีที่มีการกำหนดงานเรียกงานอย่างน้อยหนึ่งรอบ
        $years = WorkSchedule::distinct()->pluck('year');

        // ค้นหาเดือนทั้งหมด
        $months = Month::all();

        // ค้นหาปีปัจจุบัน
        $currentYear = Carbon::now()->year;

        // ค้นหาเดือนปัจจุบัน
        $currentMonth = Carbon::now()->month;

        // ค้นหา workSchedules ที่มีการกำหนดงานเรียกงานในปีและเดือนปัจจุบัน
        $workSchedules = WorkSchedule::whereHas('assignments', function ($query) use ($currentYear, $currentMonth) {
            $query->where('year', $currentYear)
                ->where('month_id', $currentMonth)
                ->whereNotNull('shift_id');
        })->get();

        // ส่งค่าตัวแปรไปยัง view 'groups.time-recording-system.schedulework.time-recording.index'
        return view('groups.time-recording-system.schedulework.time-recording.index', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'years' => $years,
            'months' => $months,
            'workSchedules' => $workSchedules,
            'currentYear' => $currentYear,
            'currentMonth' => $currentMonth
        ]);

    }
}
