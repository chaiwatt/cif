<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkScheduleAssignment extends Model
{
    use HasFactory;
    protected $fillable = [
        'work_schedule_id',
        'week_day',
        'day',
        'month',
        'year',
        'shift_id',
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

}
