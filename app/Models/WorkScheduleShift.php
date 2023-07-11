<?php

namespace App\Models;

use App\Models\Shift;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkScheduleShift extends Model
{
    use HasFactory;
    protected $fillable = [
            'work_schedule_id',
            'shift_id'
        ];

}
