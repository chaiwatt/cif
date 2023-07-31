<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkScheduleMonthNote extends Model
{
    use HasFactory;
    protected $fillable = [
        'work_schedule_id',
        'month_id',
        'year',
        'note'
    ];

    
}