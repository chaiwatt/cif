<?php

namespace App\Http\Controllers\TimeRecordingSystems;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Month;
use App\Models\Shift;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WorkScheduleAssignment;
use App\Services\UpdatedRoleGroupCollectionService;

class TimeRecordingSystemScheduleWorkTimeRecordingImportController extends Controller
{
    // Enum definition for DayType
    private const DayType = [
        'HOLIDAY' => 'holiday',
        'WORKDAY' => 'workday',
    ];

    private $updatedRoleGroupCollectionService;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
    }
    public function index($workScheduleId,$year,$monthId)
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
        $users = $this->getUsersByWorkScheduleAssignment($workScheduleId, $monthId, $year);

        // ค้นหา workSchedule จาก workScheduleId
        $workSchedule = WorkSchedule::find($workScheduleId);

        // ค้นหาเดือนที่ monthId
        $month = Month::find($monthId);

        // ส่งค่าตัวแปรไปยัง view 'groups.time-recording-system.schedulework.time-recording.import.index'
        return view('groups.time-recording-system.schedulework.time-recording.import.index', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'users' => $users,
            'workSchedule' => $workSchedule,
            'month' => $month,
            'year' => $year
        ]);

    }

    public function batch(Request $request)
    {
        // ดึงค่า month, year, workScheduleId, importUsers จาก request
        $month = $request->data['month'];
        $year = $request->data['year'];
        $importUsers = $request->data['batch'];
        // dd($importUsers);

        // หา AC-No ที่ไม่ซ้ำกันใน importUsers
        $distinctACNos = array_unique(array_column($importUsers, 'AC-No'));
        $distinctACNos = array_values($distinctACNos);

        // ค้นหาผู้ใช้ที่มี employee_no เป็น distinctACNos[0]
        $user = User::where('employee_no', $distinctACNos[0])->first();
        $results = [];
        // วนลูปตาม importUsers
        
        foreach ($importUsers as $importUser) {
            // แปลงค่า Date เป็น Carbon object
            $date = Carbon::parse($importUser['Date']);
            $day = $date->day;
            $month = $date->month;
            $year = $date->year;
            $employeeNo = $importUser['AC-No'];
            $time = $importUser['Time'];

            $date = $importUser['Date'];

            $workScheduleAssignmentUser = $user->getWorkScheduleAssignmentUserByConditions($day, $month, $year)->first();
            $shift = $workScheduleAssignmentUser->workScheduleAssignment->shift;

            $inOutTime = $this->getInOutTime($importUsers,$time,$shift,$date);
            $startDate = $inOutTime['inTime']['date'];
            $startTime = $inOutTime['inTime']['time'];
            $endDate = $inOutTime['outTime']['date'];
            $endTime = $inOutTime['outTime']['time'];
            $workScheduleAssignmentUser->update([
                    'date_in' => $startDate,
                    'date_out' => $endDate,
                    'time_in' =>  $startTime,
                    'time_out' => $endTime,
                    'original_time' => $time,
                    'code' => null
                ]);
            
        }
    }

    public function getInOutTime($importUsers,$time,$shift,$date)
    {
        return [
            'inTime' => $this->getStartTime($time,$shift,$date),
            'outTime' => $this->getEndTime($importUsers,$time,$shift,$date)
        ];
    }

    public function getStartTime($time,$shift,$date)
    {
        $startShiftTime = $shift->start;
        if ($startShiftTime == '00:00:00'){
            $startShiftTime = Shift::where('code',$shift->common_code)->first()->start;
        }
        $startShiftTime = substr($startShiftTime, 0, -3);

        $shiftTime = $date . ' ' . $startShiftTime;
        $timeParts = explode(' ', $time);

        foreach ($timeParts as $timePart) {
            $timeToCheck = $date . ' ' . $timePart;
            $times = $this->calculateBeginEndTime($shiftTime);
            if ($this->isTimeInRange($timeToCheck, $times['beginTime'], $times['endTime'])) {
                return ['date'=>$date,'time'=>$timePart];
            }
        }

        return ['date'=>$date,'time'=>null];
    }

    function calculateBeginEndTime($shiftTime)
    {
        $beginTime = Carbon::createFromFormat('Y-m-d H:i', $shiftTime)->subHours(2)->format('Y-m-d H:i');
        $endTime = Carbon::createFromFormat('Y-m-d H:i', $shiftTime)->addHours(6)->addMinutes(30)->format('Y-m-d H:i');
        return [
            'beginTime' => $beginTime,
            'endTime' => $endTime,
        ];
    }

    function isTimeInRange($time, $start, $end) {
        $time = Carbon::createFromFormat('Y-m-d H:i', $time);
        $start = Carbon::createFromFormat('Y-m-d H:i', $start);
        $end = Carbon::createFromFormat('Y-m-d H:i', $end);

        return $time->gte($start) && $time->lte($end);
    }

    public function getEndTime($importUsers,$time,$shift,$date)
    {
        $endShiftTime = $shift->end;
        if ($endShiftTime == '00:00:00'){
            $endShiftTime = Shift::where('code',$shift->common_code)->first()->end;
        }
        $endShiftTime = substr($endShiftTime, 0, -3);

        if ($shift->ShiftType == 'CROSS_DAY_SHIFT')
        {
            $date = Carbon::createFromFormat('Y-m-d', $date)->addDay()->format('Y-m-d');
            $nextImportUser = array_filter($importUsers, function ($element) use ($date) {
                    return $element['Date'] === $date;
                });
            $time = '';
            $firstFound = reset($nextImportUser);
            $time = $firstFound['Time'] ?? null;
        }

        $shiftTime = $date . ' ' . $endShiftTime;
        
        if($time == '00:00 00:00'){
            return ['date'=>$date,'time'=>null];
        }

        $timeParts = explode(' ', $time);
        foreach ($timeParts as $timePart) {
            $timeToCheck = $date . ' ' . $timePart;
            $times = $this->calculateBeginEndTime($shiftTime);
            if ($this->isTimeInRange($timeToCheck, $times['beginTime'], $times['endTime'])) {
                
                return ['date'=>$date,'time'=>$timePart];
            }
        }
        return ['date'=>$date,'time'=>null];;
    }

    public function getUsersByWorkScheduleAssignment($workScheduleId, $month, $year)
    {
        // ค้นหาผู้ใช้ที่มีการกำหนดงานเรียกงานใน workScheduleId, month, year
        $users = User::whereHas('workScheduleAssignmentUsers', function ($query) use ($workScheduleId, $month, $year) {
            $query->whereHas('workScheduleAssignment', function ($query) use ($workScheduleId, $month, $year) {
                $query->where('work_schedule_id', $workScheduleId)
                    ->where('month_id', $month)
                    ->where('year', $year);
            });
        })->paginate(50);

        return $users;
    }

}
