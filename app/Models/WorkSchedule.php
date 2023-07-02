<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\WorkScheduleAssignment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkSchedule extends Model
{
    use HasFactory;

    public function assignments()
    {
        return $this->hasMany(WorkScheduleAssignment::class);
    }

    public function workScheduleAssignments()
    {
        return $this->hasMany(WorkScheduleAssignment::class);
    }

    public function isAllShiftsAdded($monthId, $year)
    {
        // Get the current date
        $currentDate = now();
        
        // Create a Carbon instance for the given month and year
        $targetDate = Carbon::create($year, $monthId, 1)->endOfMonth();
        
        // Check if the target date is older than the current date
        if ($targetDate->lt($currentDate)) {
            return 'หมดเวลา';
        }
        
        // Retrieve the assignments for the given month and year
        $assignments = $this->workScheduleAssignments()
            ->where('work_schedule_id', $this->id)
            ->where('month_id', $monthId)
            ->where('year', $year)
            ->get();
        
        foreach ($assignments as $assignment) {
            if ($assignment->shift_id === null) {
                return false;
            }
        }
        
        return true;
    }


}
