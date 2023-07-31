<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Shift;
use App\Models\WorkScheduleUser;
use Illuminate\Support\Facades\DB;
use App\Models\WorkScheduleMonthNote;
use App\Models\WorkScheduleAssignment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkSchedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'year',
        'schedule_type_id'
    ];

    public function assignments()
    {
        return $this->hasMany(WorkScheduleAssignment::class);
    }

    public function workScheduleAssignments()
    {
        return $this->hasMany(WorkScheduleAssignment::class);
    }

    public function isUsersAssigned($monthId, $year)
    {
        // Get the current date
        $currentDate = now();
        
        // Create a Carbon instance for the given month and year
        $targetDate = Carbon::create($year, $monthId, 1)->endOfMonth();
        
        // Check if the target date is older than the current date
        if ($targetDate->lt($currentDate)) {
            return 'หมดเวลา';
        }
        return true;
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

    public function monthName($month)
    {
        return Month::find($month)->name;
    }

    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'work_schedule_shifts');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'work_schedule_users');
    }

    public function shouldUncheck()
    {
        $uncheckedIds = WorkScheduleUser::where('user_id', auth()->id())
            ->pluck('work_schedule_id')
            ->toArray();

        return in_array($this->id, $uncheckedIds);
    }

    public function getUsersByWorkScheduleAssignment($month, $year)
    {
        $users = User::whereHas('workScheduleAssignmentUsers', function ($query) use ($month, $year) {
            $query->whereHas('workScheduleAssignment', function ($query) use ($month, $year) {
                $query->where('work_schedule_id', $this->id)
                    ->where('month_id', $month)
                    ->where('year', $year);
            });
        })->get();

        return $users;
    }

    public function getWorkScheduleMonthNoteByYearAndMonth($year, $month)
    {
        return $this->workScheduleMonthNote()
            ->where('year', $year)
            ->where('month_id', $month)
            ->first();
    }

    public function workScheduleMonthNote()
    {
        return $this->hasOne(WorkScheduleMonthNote::class);
    }


}
