<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkScheduleAssignmentUserFile extends Model
{
    use HasFactory;
    protected $fillable = [
        'work_schedule_assignment_user_id',
        'file'
    ];
}