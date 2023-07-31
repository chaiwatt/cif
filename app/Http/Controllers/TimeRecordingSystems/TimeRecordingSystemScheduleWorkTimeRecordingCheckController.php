<?php

namespace App\Http\Controllers\TimeRecordingSystems;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Month;
use App\Models\PayDayRange;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use App\Models\WorkScheduleUser;
use App\Http\Controllers\Controller;
use App\Models\WorkScheduleMonthNote;
use App\Models\WorkScheduleAssignmentUser;
use App\Services\UpdatedRoleGroupCollectionService;

class TimeRecordingSystemScheduleWorkTimeRecordingCheckController extends Controller
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
        $viewName = $roleGroupCollection['viewName'];
        // dd($viewName);

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
        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'years' => $years,
            'months' => $months,
            'workSchedules' => $workSchedules,
            'year' => $currentYear,
            'month' => $currentMonth
        ]);

    }
    public function search(Request $request)
    {        
        $selectedYear = $request->data['selectedYear'];
        $selectedMonth = $request->data['selectedMonth'];

        $uncheckedIds = WorkScheduleUser::where('user_id', auth()->id())
            ->pluck('work_schedule_id')
            ->toArray();

        $workSchedules = WorkSchedule::whereHas('assignments', function ($query) use ($selectedYear, $selectedMonth) {
            $query->where('year', $selectedYear)
                ->where('month_id', $selectedMonth)
                ->whereNotNull('shift_id');
        })->whereNotIn('id', $uncheckedIds)
        ->get();

        return view('groups.time-recording-system.schedulework.time-recording-check.table-render.work-schedule-table',[
            'workSchedules' => $workSchedules,
            'month' => $selectedMonth,
            'year' => $selectedYear,
            ])->render();
    }

    public function view($workScheduleId,$year,$monthId)
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'show'
        $action = 'show';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];

        // ค้นหาผู้ใช้ตามการกำหนดงานเรียกงานใน workScheduleId, monthId, year
        // $users = $this->getUsersByWorkScheduleAssignment($workScheduleId, $monthId, $year);

        // ค้นหา workSchedule จาก workScheduleId
        $workSchedule = WorkSchedule::find($workScheduleId);

        // ค้นหาเดือนที่ monthId
        $month = Month::find($monthId);
        $payDayRanges = PayDayRange::all();

        // ส่งค่าตัวแปรไปยัง view 'groups.time-recording-system.schedulework.time-recording.import.index'
        return view('groups.time-recording-system.schedulework.time-recording-check.view', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            // 'users' => $users,
            'workSchedule' => $workSchedule,
            'month' => $month,
            'year' => $year,
            'payDayRanges' => $payDayRanges
        ]);
    }

    public function timeRecordCheck(Request $request)
    {
        $startDate = Carbon::createFromFormat('d/m/Y', $request->data['startDate'])->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y', $request->data['endDate'])->format('Y-m-d');
        $monthId = $request->data['monthId'];
        $year = $request->data['year'];
        $workScheduleId = $request->data['workScheduleId'];

        $users = $this->getUsersByWorkScheduleAssignment($startDate, $endDate);

        $usersWithWorkScheduleAssignments = [];
        foreach($users as $user)
        {
            $workScheduleAssignmentUsers = $user->getWorkScheduleAssignmentUsersInformation($startDate,$endDate, $year);
            $usersWithWorkScheduleAssignments[$user->id] = [
                'user' => $user,
                'date_in_list' => $workScheduleAssignmentUsers->pluck('date_in')->toArray()
            ];   
        }

        return view('groups.time-recording-system.schedulework.time-recording-check.table-render.work-schedule-check-table',[
            'usersWithWorkScheduleAssignments' => $usersWithWorkScheduleAssignments
            ])->render();

    }

    public function viewUser(Request $request)
    {
        $startDate = Carbon::createFromFormat('d/m/Y', $request->data['startDate'])->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y', $request->data['endDate'])->format('Y-m-d');
        $year = $request->data['year'];
        $userId = $request->data['userId'];
        
        $user = User::find($userId);
        $workScheduleAssignmentUsers = $user->getWorkScheduleAssignmentUsersByConditions($startDate,$endDate, $year);
        return view('groups.time-recording-system.schedulework.time-recording-check.table-render.work-schedule-modal-table',[
            'workScheduleAssignmentUsers' => $workScheduleAssignmentUsers
            ])->render();

    }

    public function update(Request $request)
    {
        $timeInValue = $request->data['timeInValue'];
        $timeOutValue = $request->data['timeOutValue'];
        $workScheduleAssignmentUserId = $request->data['workScheduleAssignmentUserId'];

        $workScheduleAssignmentUser = WorkScheduleAssignmentUser::find($workScheduleAssignmentUserId)->update([
            'time_in' => $timeInValue,
            'time_out' => $timeOutValue,
            'code' => 'E'
        ]);

        $startDate = Carbon::createFromFormat('d/m/Y', $request->data['startDate'])->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y', $request->data['endDate'])->format('Y-m-d');
        $monthId = $request->data['monthId'];
        $year = $request->data['year'];
        $workScheduleId = $request->data['workScheduleId'];

        $users = $this->getUsersByWorkScheduleAssignment($startDate, $endDate);

        $usersWithWorkScheduleAssignments = [];
        foreach($users as $user)
        {
            $workScheduleAssignmentUsers = $user->getWorkScheduleAssignmentUsersInformation($startDate,$endDate, $year);
            $usersWithWorkScheduleAssignments[$user->id] = [
                'user' => $user,
                'date_in_list' => $workScheduleAssignmentUsers->pluck('date_in')->toArray()
                
            ];   
        }

        return view('groups.time-recording-system.schedulework.time-recording-check.table-render.work-schedule-check-table',[
            'usersWithWorkScheduleAssignments' => $usersWithWorkScheduleAssignments
            ])->render();
    }

    public function saveNote(Request $request){
        $note = $request->data['note'];
        $monthId = $request->data['monthId'];
        $workScheduleId = $request->data['workScheduleId'];
        $year = $request->data['year'];

        WorkScheduleMonthNote::updateOrCreate(
            [
                'work_schedule_id' => $workScheduleId,
                'month_id' => $monthId,
                'year' => $year,
            ],
            [
                'note' => $note
            ]
        );
    }

    public function getUsersByWorkScheduleAssignment($startDate,$endDate)
    {
        // ค้นหาผู้ใช้ที่มีการกำหนดงานเรียกงานใน workScheduleId, month, year
        // $users = User::whereHas('workScheduleAssignmentUsers', function ($query) use ($workScheduleId, $year) {
        //     $query->whereHas('workScheduleAssignment', function ($query) use ($workScheduleId, $year) {
        //         $query->where('work_schedule_id', $workScheduleId)
        //             // ->where('month_id', $month)
        //             ->where('year', $year);
        //     })->whereNotNull('date_in');
        // })->get();

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

    // public function getUsersByWorkScheduleAssignment($workScheduleId, $month, $year)
    // {
    //     // ค้นหาผู้ใช้ที่มีการกำหนดงานเรียกงานใน workScheduleId, month, year
    //     $users = User::whereHas('workScheduleAssignmentUsers', function ($query) use ($workScheduleId, $month, $year) {
    //         $query->whereHas('workScheduleAssignment', function ($query) use ($workScheduleId, $month, $year) {
    //             $query->where('work_schedule_id', $workScheduleId)
    //                 ->where('month_id', $month)
    //                 ->where('year', $year);
    //         });
    //     })->paginate(50);

    //     return $users;
    // }
}