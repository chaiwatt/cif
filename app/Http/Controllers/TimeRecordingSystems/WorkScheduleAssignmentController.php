<?php

namespace App\Http\Controllers\TimeRecordingSystems;

use App\Models\User;
use App\Models\Shift;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WorkScheduleAssignment;
use App\Models\WorkScheduleAssignmentUser;
use App\Helpers\AddDefaultWorkScheduleAssignment;

class WorkScheduleAssignmentController extends Controller
{
    public function assign()
    {
        $workScheduleId = 1;
        $userId = 1;
        $month = 8;
        $year = 2023;


        $user = User::find($userId);
        $workScheduleAssignments = WorkScheduleAssignment::where('work_schedule_id', $workScheduleId)
            ->where('month_id', $month)
            ->where('year', $year)
            ->get();

        $user->detachWorkScheduleAssignments($workScheduleId, $month, $year);    

        $user->attachWorkScheduleAssignments($workScheduleAssignments);

        return ('assigned');
    }
    public function index()
    {
        $workScheduleId = 1;
        $userId = 1;
        $month = 7;
        $year = 2023;
        $weekDay = 6;
        $day = 1;
        $workSchedule = WorkSchedule::find($workScheduleId);
        $user = User::find($userId);

        // $user = User::find(123);
        $month = 6;
        $year = 2023;

        $workScheduleUser = $user->getWorkScheduleUserByMonthYear($month, $year);
        $workScheduleAssignmentUser = $user->getWorkScheduleAssignmentUserByConditions($weekDay, $day, $month, $year);
        $workScheduleAssignmentUsers = $user->getWorkScheduleAssignmentUsersByConditions($month, $year);


        // $workScheduleAssignmentUsers = $this->getWorkScheduleAssignmentUsersByConditions($month, $year, $userId);

        // // dd($workScheduleAssignmentUsers);
        // foreach($workScheduleAssignmentUsers as $workScheduleAssignmentUser)
        // {
        //     echo($user->name . ' ' . $workScheduleAssignmentUser->workScheduleAssignment->month->name . ' ' . $workScheduleAssignmentUser->workScheduleAssignment->year . ' ' . $workScheduleAssignmentUser->time_in . ' ' . $workScheduleAssignmentUser->time_out . '<br>');
        // }
        
        // $workScheduleAssignmentUser = $this->getWorkScheduleAssignmentUserByConditions($weekDay, $day, $month, $year, $userId);
        // // dd($workScheduleAssignmentUser);

        // $users = $this->getUsersByWorkScheduleAssignment($workScheduleId, $month, $year);

        // // foreach($users as $user)
        // // {
        // //     echo($workSchedule->name . ' ' . $user->name . '<br>');
        // // }

        // $workScheduleUserByMonthYears = $this->getWorkScheduleUserByMonthYear($weekDay, $day, $month, $year, $userId);

    }
    public function getWorkScheduleUserByMonthYear($month, $year, $userId)
    {
        $workScheduleUser = WorkScheduleAssignmentUser::whereHas('workScheduleAssignment', function ($query) use ($month, $year) {
            $query->where('month_id', $month)
                ->where('year', $year);
        })->where('user_id', $userId)->first();

        return $workScheduleUser;
    }


    public function getWorkScheduleAssignmentUserByConditions($weekDay, $day, $month, $year, $userId)
    {
        $workScheduleAssignmentUser = WorkScheduleAssignmentUser::whereHas('workScheduleAssignment', function ($query) use ($weekDay, $day, $month, $year) {
            $query->where('week_day', $weekDay)
                ->where('day', $day)
                ->where('month_id', $month)
                ->where('year', $year);
        })->where('user_id', $userId)->first();

        return $workScheduleAssignmentUser;
    }

    public function getWorkScheduleAssignmentUsersByConditions($month, $year, $userId)
    {
        $workScheduleAssignmentUsers = WorkScheduleAssignmentUser::whereHas('workScheduleAssignment', function ($query) use ($month, $year) {
            $query->where('month_id', $month)
                ->where('year', $year);
        })->where('user_id', $userId)->get();

        return $workScheduleAssignmentUsers;
    }

    public function getUsersByWorkScheduleAssignment($workScheduleId, $month, $year)
    {
        $users = User::whereHas('workScheduleAssignmentUsers', function ($query) use ($workScheduleId, $month, $year) {
            $query->whereHas('workScheduleAssignment', function ($query) use ($workScheduleId, $month, $year) {
                $query->where('work_schedule_id', $workScheduleId)
                    ->where('month_id', $month)
                    ->where('year', $year);
            });
        })->get();

        return $users;
    }

}
