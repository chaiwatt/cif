<?php

namespace App\Http\Controllers\Jobs;

use App\Models\User;
use App\Models\Shift;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WorkScheduleAssignment;
use App\Models\WorkScheduleAssignmentUser;
use App\Helpers\AddDefaultWorkScheduleAssignment;

class WorkScheduleController extends Controller
{
    public function index()
    {
        $shift = Shift::findOrFail(1);
        $workSchedule = WorkSchedule::findOrFail(1);
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($shift,$workSchedule);

        $user = User::find(2); 
        $workScheduleAssignments = WorkScheduleAssignment::where('work_schedule_id',1)->get();
        $user->workScheduleAssignments()->detach(); 
        $user->workScheduleAssignments()->attach($workScheduleAssignments); 
        
        $userId = $user->id;
        $month = 6;
        $year = 2023;

        $workScheduleAssignments = $this->getWorkScheduleAssignmentsForUser($userId, $month, $year);
        $workScheduleAssignmentUsers = $this->getWorkScheduleAssignmentUsers($workScheduleAssignments);

        foreach ($workScheduleAssignmentUsers as $workScheduleAssignmentUser)
        {
            $workScheduleAssignmentUserId = $workScheduleAssignmentUser->id;
            $workScheduleAssignmentUserTimeIn = $workScheduleAssignmentUser->time_in;
            $workScheduleAssignmentUserTimeOut = $workScheduleAssignmentUser->time_out;
            print($workScheduleAssignmentUserId . ' <--> ' . $workScheduleAssignmentUserTimeIn . ' <--> ' . $workScheduleAssignmentUserTimeOut) . '<br>';
        }

        foreach ($workScheduleAssignments as $workScheduleAssignment) {
            $workScheduleAssignmentId = $workScheduleAssignment->id;
            $workScheduleAssignmentDay = $workScheduleAssignment->day;
            $workScheduleAssignmentShift = $workScheduleAssignment->shift_id;
            print($workScheduleAssignmentId . ' ' . $workScheduleAssignmentDay . ' ' . $workScheduleAssignmentShift) . '<br>';
        }

    }

    public function getWorkScheduleAssignmentUsers($workScheduleAssignments)
    {
        $workScheduleAssignmentIds = $workScheduleAssignments->pluck('id')->toArray();
        $workScheduleAssignmentUsers = WorkScheduleAssignmentUser::whereIn('work_schedule_assignment_id', $workScheduleAssignmentIds)->get();

        return $workScheduleAssignmentUsers;
    }

    function getWorkScheduleAssignmentsForUser($userId, $month, $year)
    {
        $workScheduleAssignments = WorkScheduleAssignment::whereHas('users', function ($query) use ($userId) {
            $query->whereKey($userId);
        })
        ->where('month', $month)
        ->where('year', $year)
        ->get();

        return $workScheduleAssignments;
    }
}
