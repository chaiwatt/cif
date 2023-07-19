<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\WorkScheduleAssignment;
use App\Models\WorkScheduleAssignmentUser;

class TestController extends Controller
{
    public function isDateValid()
    {
        $datein = '2023-05-19';
        // $time1 = '02:54:00';
        $time1 = '15:45:00';
        $dateout = '2023-05-20';
        // $time2 = '15:45:00';
        $time2 = '02:54:00';

        // Combine the date and time values
        $datetimein = Carbon::parse($datein . ' ' . $time1);
        $datetimeout = Carbon::parse($dateout . ' ' . $time2);

        // Calculate the initial hour difference
        $hourDifference = $datetimein->diffInHours($datetimeout);

        if ($hourDifference > 24) {
            $datetimein = Carbon::parse($datein . ' ' . $time2);
            $datetimeout = Carbon::parse($dateout . ' ' . $time1);
            $hourDifference = $datetimein->diffInHours($datetimeout);
            $datein = $datetimein;
            $dateout = $datetimeout;
        } else {
            $datein = $datetimein;
            $dateout = $datetimeout;
        }

        echo "Date In: $datein \n";
        echo "Date Out: $dateout \n";
        echo "Hour Difference: $hourDifference\n";

    }

    public function clearDB()
    {
        DB::table('work_schedule_assignments')
        ->update(['start_shift' => 0]);
        DB::table('work_schedule_assignment_users')
        ->update(
            [
                'date_in' => null,
                'date_out' =>null,
                'time_in' => null,
                'time_out' =>null,
                'original_time' =>null,
                'code' =>null
        ]);
    }

    public function classifyDate()
    {
        $currentDate = '2023-05-25';
       
        $time = '15:35 02:50';
        $startShiftTime = '16:00';
        $endShiftTime = '01:00';
        // $shiftType = 'FULL_DAY_SHIFT';
        $shiftType = 'CROSS_DAY_SHIFT';
        $timeIn = $this->getStartTime($time,$currentDate,$startShiftTime);
        $timeOut = $this->getEndTime($time,$currentDate,$endShiftTime,$shiftType);
        dd($timeIn,$timeOut);

    }

    public function getStartTime($time, $date, $startShiftTime)
    {
        $shiftTime = $date . ' ' . $startShiftTime;
        $timeParts = explode(' ', $time);

        foreach ($timeParts as $timePart) {
            $timeToCheck = $date . ' ' . $timePart;
            $times = $this->calculateBeginEndTime($shiftTime);
            if ($this->isTimeInRange($timeToCheck, $times['beginTime'], $times['endTime'])) {
                return $timePart;
            }
        }

        return null;
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

    public function getEndTime($time,$date,$endShiftTime,$shiftType)
    {
        if ($shiftType == 'CROSS_DAY_SHIFT')
        {
            $date = Carbon::createFromFormat('Y-m-d', $date)->addDay()->format('Y-m-d');
        }
        $shiftTime = $date . ' ' . $endShiftTime;
        
        $timeParts = explode(' ', $time);
        foreach ($timeParts as $timePart) {
            $timeToCheck = $date . ' ' . $timePart;
            $times = $this->calculateBeginEndTime($shiftTime);

            if ($this->isTimeInRange($timeToCheck, $times['beginTime'], $times['endTime'])) {
                
                return $timePart;
            }
        }
        return null;
    }

  

    
}
