<?php

namespace App\Http\Controllers\jobs;

use App\Models\User;
use App\Models\Shift;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WorkScheduleAssignment;
use App\Models\WorkScheduleAssignmentUser;
use App\Helpers\AddDefaultWorkScheduleAssignment;

class WorkScheduleAssignmentController extends Controller
{
    public function create()
    {
        $shift = Shift::findOrFail(1);
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($shift);
        return ('created');
    }
    public function assign()
    {
        $user = User::find(4); 
        $workScheduleAssignments = WorkScheduleAssignment::where('shift_id',1)->get();
        $user->workScheduleAssignments()->detach(); 
        $user->workScheduleAssignments()->attach($workScheduleAssignments); 
        return ('assigned');
    }
    public function index()
    {
        // $user = User::find(1); 
        $userId = 1;
        $shiftId = 1;
        $month = 7;
        $year = 2023;
        $weekDay = 6;
        $day = 1;

        $workScheduleAssignmentUsers = $this->getWorkScheduleAssignmentUsersByConditions($shiftId, $month, $year, $userId);
        
        $workScheduleAssignmentUser = $this->getWorkScheduleAssignmentUserByConditions($shiftId, $weekDay, $day, $month, $year, $userId);
        dd($workScheduleAssignmentUser);

        $users = $this->getUsersByWorkScheduleAssignment($shiftId, $month, $year);

        foreach($users as $user)
        {
            echo($user->name . '<br>');
        }

    }

    public function getWorkScheduleAssignmentUserByConditions($shiftId, $weekDay, $day, $month, $year, $userId)
    {
        $workScheduleAssignmentUser = WorkScheduleAssignmentUser::whereHas('workScheduleAssignment', function ($query) use ($shiftId, $weekDay, $day, $month, $year) {
            $query->where('shift_id', $shiftId)
                ->where('week_day', $weekDay)
                ->where('day', $day)
                ->where('month', $month)
                ->where('year', $year);
        })->where('user_id', $userId)->first();

        return $workScheduleAssignmentUser;
    }

    public function getWorkScheduleAssignmentUsersByConditions($shiftId, $month, $year, $userId)
    {
        $workScheduleAssignmentUsers = WorkScheduleAssignmentUser::whereHas('workScheduleAssignment', function ($query) use ($shiftId, $month, $year) {
            $query->where('shift_id', $shiftId)
                ->where('month', $month)
                ->where('year', $year);
        })->where('user_id', $userId)->get();

        return $workScheduleAssignmentUsers;
    }

    public function getUsersByWorkScheduleAssignment($shiftId, $month, $year)
    {
        $users = User::whereHas('workScheduleAssignmentUsers', function ($query) use ($shiftId, $month, $year) {
            $query->whereHas('workScheduleAssignment', function ($query) use ($shiftId, $month, $year) {
                $query->where('shift_id', $shiftId)
                    ->where('month', $month)
                    ->where('year', $year);
            });
        })->get();

        return $users;
    }

}
