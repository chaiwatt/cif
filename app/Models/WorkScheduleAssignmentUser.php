<?php

namespace App\Models;

use App\Models\User;
use App\Models\WorkScheduleAssignment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkScheduleAssignmentUser extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'work_schedule_assignment_id',
        'user_id',
        'time_in',
        'time_out',
    ];

    /**
     * ความสัมพันธ์กับโมเดล WorkScheduleAssignment (การกำหนดตารางเวลางาน)
     * ผ่านการเชื่อมโยงกับโมเดล WorkScheduleAssignment (การกำหนดตารางเวลางาน)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workScheduleAssignment()
    {
        return $this->belongsTo(WorkScheduleAssignment::class);
    }


    /**
     * ความสัมพันธ์กับโมเดล User (ผู้ใช้งาน)
     * ผ่านการเชื่อมโยงกับโมเดล User (ผู้ใช้งาน)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    }
