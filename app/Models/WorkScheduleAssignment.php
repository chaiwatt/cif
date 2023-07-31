<?php

namespace App\Models;

use App\Models\User;
use App\Models\Month;
use App\Models\Shift;
use App\Models\WorkSchedule;
use App\Models\WorkScheduleMonthNote;
use Illuminate\Database\Eloquent\Model;
use App\Models\WorkScheduleAssignmentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkScheduleAssignment extends Model
{
    use HasFactory;
    protected $fillable = [
        'work_schedule_id',
        'week_day',
        'day',
        'month_id',
        'year',
        'shift_id',
        'start_shift'
    ];
    
    /**
     * ความสัมพันธ์กับโมเดล User (ผู้ใช้งาน)
     * ผ่านการเชื่อมโยงกับโมเดล User (ผู้ใช้งาน)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'work_schedule_assignment_users', 'work_schedule_assignment_id', 'user_id')
            ->withPivot('time_in', 'time_out');
    }
    /**
     * ความสัมพันธ์กับโมเดล Shift (กะงาน)
     * ผ่านการเชื่อมโยงกับโมเดล Shift (กะงาน)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }


    /**
     * ความสัมพันธ์กับโมเดล WorkScheduleAssignmentUser (การมองเห็นตารางเวลางานผู้ใช้งาน)
     * ผ่านการเชื่อมโยงกับโมเดล WorkScheduleAssignmentUser (การมองเห็นตารางเวลางานผู้ใช้งาน)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workScheduleAssignmentUsers()
    {
        return $this->hasMany(WorkScheduleAssignmentUser::class);
    }

    /**
     * ความสัมพันธ์กับโมเดล WorkSchedule (ตารางทำงาน)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function work_schedule()
    {
        return $this->belongsTo(WorkSchedule::class);
    }

    /**
     * ความสัมพันธ์กับโมเดล Month (เดือน)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function month()
    {
        return $this->belongsTo(Month::class);
    }

    public function workSchedule()
    {
        return $this->belongsTo(WorkSchedule::class, 'work_schedule_id');
    }


}
