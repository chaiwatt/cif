<?php

namespace App\Http\Controllers\TimeRecordingSystems;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Month;
use App\Models\Shift;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PayDayRange;
use App\Models\WorkScheduleAssignment;
use App\Services\UpdatedRoleGroupCollectionService;

class TimeRecordingSystemScheduleWorkTimeRecordingImportController extends Controller
{
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
        $payDayRanges = PayDayRange::all();

        // ส่งค่าตัวแปรไปยัง view 'groups.time-recording-system.schedulework.time-recording.import.index'
        return view('groups.time-recording-system.schedulework.time-recording.import.index', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'users' => $users,
            'workSchedule' => $workSchedule,
            'month' => $month,
            'year' => $year,
            'payDayRanges' => $payDayRanges
        ]);

    }

    public function batch(Request $request)
    {
        $month = null;
        $year = null;
        $importUsers = $request->data['batch'];

        $startDateRange = Carbon::createFromFormat('d/m/Y', $request->data['start_date'])->startOfDay();
        $endDateRange = Carbon::createFromFormat('d/m/Y', $request->data['end_date'])->endOfDay();

        // dd($startDateRange,$endDateRange);
        
        // วนลูปตาม importUsers
        foreach ($importUsers as $importUser) {
            
            $date = Carbon::parse($importUser['Date'])->startOfDay();

            if ($date->isBefore($startDateRange) || $date->isAfter($endDateRange)) {
                continue; // Skip processing for this importUser
            }
            
            $day = $date->day;
            $month = $date->month;
            $year = $date->year;
            $time = $importUser['Time'];
            $date = $importUser['Date'];
            $user = User::where('employee_no', $importUser['AC-No'])->first();

            $workScheduleAssignmentUser = $user->getWorkScheduleAssignmentUserByConditions($day, $month, $year)->first();

            if (!$workScheduleAssignmentUser) {
                return response()->json(['error' => 'work schedule not found for ' . $user->name ]);
            }

            $shift = $workScheduleAssignmentUser->workScheduleAssignment->shift;

            $inOutTime = $this->getInOutTime($importUsers,$user,$time,$shift,$date);
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

        // dd($inOutTime);
    }

    public function batchAutoDetect(Request $request)
    {
        $month = null;
        $year = null;
        $importUsers = $request->data['batch'];
        
        // วนลูปตาม importUsers
        foreach ($importUsers as $importUser) {

            $user = User::where('employee_no', $importUser['AC-No'])->first();

            $paydayDetails = $user->getPaydayDetailWithTodays();
            $minStartDate = $paydayDetails->min('start_date');
            $maxEndDate = $paydayDetails->max('end_date');

            $startDateRange = Carbon::createFromFormat('Y-m-d', $minStartDate)->startOfDay();
            $endDateRange = Carbon::createFromFormat('Y-m-d', $maxEndDate)->endOfDay();

            // dd($startDateRange,$endDateRange);
            
            $date = Carbon::parse($importUser['Date'])->startOfDay();

            if ($date->isBefore($startDateRange) || $date->isAfter($endDateRange)) {
                continue; // Skip processing for this importUser
            }
            
            $day = $date->day;
            $month = $date->month;
            $year = $date->year;
            $time = $importUser['Time'];
            $date = $importUser['Date'];
            $user = User::where('employee_no', $importUser['AC-No'])->first();

            $workScheduleAssignmentUser = $user->getWorkScheduleAssignmentUserByConditions($day, $month, $year)->first();

            if (!$workScheduleAssignmentUser) {
                return response()->json(['error' => 'work schedule not found for ' . $user->name ]);
            }

            $shift = $workScheduleAssignmentUser->workScheduleAssignment->shift;

            $inOutTime = $this->getInOutTime($importUsers,$user,$time,$shift,$date);
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

    public function getInOutTime($importUsers,$user,$time,$shift,$date)
    {
        return [
            'inTime' => $this->getStartTime($time,$user,$shift,$date),
            'outTime' => $this->getEndTime($importUsers,$user,$time,$shift,$date)
        ];
    }

    public function getStartTime($time,$user,$shift,$date)
    {
        $startShiftTime = $shift->start;
        if ($startShiftTime == '00:00:00'){
            $startShiftTime = Shift::where('code',$shift->common_code)->first()->start;
        }
        
        $startShiftTime = substr($startShiftTime, 0, -3);
        
        $shiftTime = $date . ' ' . $startShiftTime;
        $timeParts = explode(' ', $time);

        if($time == '00:00 00:00' && $user->time_record_require != '0'){
            return ['date'=>$date,'time'=>null];
        }
        
        if ($user->time_record_require == '1'){
            foreach ($timeParts as $timePart) {
                $timeToCheck = $date . ' ' . $timePart;
                $times = $this->calculateBeginEndTime($shiftTime,$shift);
                if ($this->isTimeInRange($timeToCheck, $times['beginTime'], $times['endTime'])) {
                    return ['date'=>$date,'time'=>$timePart];
                }
            }
        }else if($user->time_record_require == '0') {
            return ['date'=>$date,'time'=>$startShiftTime];
        }

        
        return ['date'=>$date,'time'=>null];
    }

    function calculateBeginEndTime($shiftTime,$shift)
    {
        $record_start = $shift->record_start;
        $record_start_hours = intVal(floor($record_start));
        $record_start_minutes = intVal(($record_start - $record_start_hours) * 60); 

        $record_end = $shift->record_end;
        $record_end_hours = intVal(floor($record_end));
        $record_end_minutes = intVal(($record_end - $record_end_hours) * 60); 

        $beginTime = Carbon::createFromFormat('Y-m-d H:i', $shiftTime)
                        ->subHours($record_start_hours)
                        ->subMinutes($record_start_minutes)
                        ->format('Y-m-d H:i');
        $endTime = Carbon::createFromFormat('Y-m-d H:i', $shiftTime)
                        ->addHours($record_end_hours)
                        ->addMinutes($record_end_minutes)
                        ->format('Y-m-d H:i');
        return [
            'beginTime' => $beginTime,
            'endTime' => $endTime,
        ];

    }

    public function getEndTime($importUsers,$user,$time,$shift,$date)
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
        
        if($time == '00:00 00:00' && $user->time_record_require != '0'){
            return ['date'=>$date,'time'=>null];
        }
        
        $timeParts = explode(' ', $time);
        if ($user->time_record_require == '1'){
            foreach ($timeParts as $timePart) {
                $timeToCheck = $date . ' ' . $timePart;
                $times = $this->calculateBeginEndTime($shiftTime,$shift);

                $beginTimeDateFormat = Carbon::createFromFormat('Y-m-d H:i', $times['beginTime']);
                $endTimeDateFormat = Carbon::createFromFormat('Y-m-d H:i', $times['endTime']);

                if ($beginTimeDateFormat->format('Y-m-d') == $endTimeDateFormat->format('Y-m-d')) {
                    if ($this->isTimeInRange($timeToCheck, $times['beginTime'], $times['endTime'])) {
                        return ['date'=>$date,'time'=>$timePart];
                    }
                }else if($beginTimeDateFormat->format('Y-m-d') != $endTimeDateFormat->format('Y-m-d'))
                {
                    $dateInDateFormat = Carbon::createFromFormat('Y-m-d', $date);
                    $timeToCheckPrevious = $dateInDateFormat->copy()->subDay()->format('Y-m-d');
                    if ($this->isTimeInRange($timeToCheck, $times['beginTime'], $times['endTime'])) {     
                        return ['date'=>$date,'time'=>$timePart];
                    }else if($this->isTimeInRange($timeToCheckPrevious. ' ' . $timePart, $times['beginTime'], $times['endTime']))
                    {
                        return ['date'=>$timeToCheckPrevious,'time'=>$timePart];
                    }
                }   
            }
        }else if($user->time_record_require == '0'){
            $timeToCheck = $date . ' ' . $endShiftTime;
            $times = $this->calculateBeginEndTime($shiftTime,$shift);

            $beginTimeDateFormat = Carbon::createFromFormat('Y-m-d H:i', $times['beginTime']);
            $endTimeDateFormat = Carbon::createFromFormat('Y-m-d H:i', $times['endTime']);

            if ($beginTimeDateFormat->format('Y-m-d') == $endTimeDateFormat->format('Y-m-d')) {
                if ($this->isTimeInRange($timeToCheck, $times['beginTime'], $times['endTime'])) {
                    return ['date'=>$date,'time'=>$endShiftTime];
                }
            }else if($beginTimeDateFormat->format('Y-m-d') != $endTimeDateFormat->format('Y-m-d'))
            {
                $dateInDateFormat = Carbon::createFromFormat('Y-m-d', $date);
                $timeToCheckPrevious = $dateInDateFormat->copy()->subDay()->format('Y-m-d');
                if ($this->isTimeInRange($timeToCheck, $times['beginTime'], $times['endTime'])) {     
                    return ['date'=>$date,'time'=>$endShiftTime];
                }else if($this->isTimeInRange($timeToCheckPrevious. ' ' . $endShiftTime, $times['beginTime'], $times['endTime']))
                {
                    return ['date'=>$timeToCheckPrevious,'time'=>$endShiftTime];
                }
            } 
        }
        
        return ['date'=>$date,'time'=>null];;
    }

    public function showInfo()
    {
        
        $startDate = '2023-04-26';
        $endDate = '2023-05-25';
        $user = User::where('employee_no','220115')->first();
        $workScheduleAssignmentUsers = $user->getWorkScheduleAssignmentUsers($startDate, $endDate);
        foreach($workScheduleAssignmentUsers as $workScheduleAssignmentUser)
        {
            echo($workScheduleAssignmentUser->date_in . ' <br>');
        }
        return;
    }

    function isTimeInRange($time, $start, $end) {
        $time = Carbon::createFromFormat('Y-m-d H:i', $time);
        $start = Carbon::createFromFormat('Y-m-d H:i', $start);
        $end = Carbon::createFromFormat('Y-m-d H:i', $end);
        return $time->gte($start) && $time->lte($end);
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
