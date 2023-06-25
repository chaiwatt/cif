<?php

namespace App\Models;

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
}
