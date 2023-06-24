<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\Shift;

use App\Models\WorkScheduleAssignment;

class AddDefaultWorkScheduleAssignment
{
    public function addDefaultWorkScheduleAssignment(Shift $shift)
    {
        $shiftId = $shift->id;
        $year = 2023;
        $month = 7;
        $days = $this->getAllDaysInMonth($year, $month);
        // You can loop through the $days array and access the 'day' and 'dayOfWeek' values for each day
        if (!WorkScheduleAssignment::where('month', $month)->where('year', $year)->exists()) {
            foreach ($days as $day) {
                WorkScheduleAssignment::create([
                    'week_day' => $day['dayOfWeek'],
                    'day' => $day['day'],
                    'month' => $month,
                    'year' => $year,
                    'shift_id' => $shiftId,
                ]);
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

