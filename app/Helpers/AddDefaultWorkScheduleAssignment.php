<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\Shift;

use App\Models\WorkSchedule;
use App\Models\WorkScheduleAssignment;

class AddDefaultWorkScheduleAssignment
{
    public function addDefaultWorkScheduleAssignment(WorkSchedule $workSchedule,$year)
    {
        for ($month = 1; $month <= 12; $month++) {
            $days = $this->getAllDaysInMonth($year, $month);
            
            if (!WorkScheduleAssignment::where('work_schedule_id', $workSchedule->id)->where('month_id', $month)->where('year', $year)->exists()) {
                foreach ($days as $day) {
                    WorkScheduleAssignment::create([
                        'work_schedule_id' => $workSchedule->id,
                        'week_day' => $day['dayOfWeek'],
                        'day' => $day['day'],
                        'month_id' => $month,
                        'year' => $year,
                        'shift_id' => Null,
                    ]);
                }
            }
        }
    }
    function getAllDaysInMonth($year, $month)
    {
        $startDate = Carbon::createFromDate($year, $month, 1);
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();
        
        $days = [];
        
        while ($startDate <= $endDate) {
            $dayOfMonth = (int) $startDate->format('d');
            $dayOfWeek = (int) $startDate->format('N');
            
            $days[] = [
                'day' => $dayOfMonth,
                'dayOfWeek' => $dayOfWeek,
            ];
            
            $startDate->addDay();
        }
        
        return $days;
    } 
}

