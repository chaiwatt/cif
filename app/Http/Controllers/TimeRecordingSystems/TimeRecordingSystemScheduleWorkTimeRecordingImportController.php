<?php

namespace App\Http\Controllers\TimeRecordingSystems;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Month;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WorkScheduleAssignment;
use App\Services\UpdatedRoleGroupCollectionService;

class TimeRecordingSystemScheduleWorkTimeRecordingImportController extends Controller
{
    private $updatedRoleGroupCollectionService;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
    }
    public function index($workScheduleId,$year,$monthId)
    {
        $action = 'show';
        $groupUrl = strval(session('groupUrl'));
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $users = $this->getUsersByWorkScheduleAssignment($workScheduleId, $monthId, $year);
        $workSchedule = WorkSchedule::find($workScheduleId);
        $month = Month::find($monthId);
        return view('groups.time-recording-system.schedulework.time-recording.import.index', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'users' => $users,
            'workSchedule' => $workSchedule,
            'month' => $month,
            'year' => $year
        ]);
    }

    public function batch(Request $request)
    {

        $month = $request->data['month'];
        $year = $request->data['year'];
        $workScheduleId = $request->data['workScheduleId'];
        $importUsers = $request->data['batch'];
        $distinctACNos = array_unique(array_column($importUsers, 'AC-No'));
        $distinctACNos = array_values($distinctACNos);
        $user = User::where('employee_no',$distinctACNos[0])->first();

        foreach($importUsers as $importUser)
        {
            $date = Carbon::parse($importUser['Date']); 
            $day = $date->day;
            $month = $date->month;
            $year = $date->year;
            $employeeNo = $importUser['AC-No'];
            $user = User::where('employee_no',$employeeNo)->first();
           
            $workScheduleAssignmentUser = $user->getWorkScheduleAssignmentUserByConditions($day, $month, $year)->first();
            if($workScheduleAssignmentUser)
            {
                $workScheduleAssignmentUser->update([
                    'time_in' => '00:00:00',
                    'time_out' => '00:00:00',
                ]);
            }
        }

        return response()->json($importUsers);
    }

    public function getUsersByWorkScheduleAssignment($workScheduleId, $month, $year)
    {
        $users = User::whereHas('workScheduleAssignmentUsers', function ($query) use ($workScheduleId, $month, $year) {
            $query->whereHas('workScheduleAssignment', function ($query) use ($workScheduleId, $month, $year) {
                $query->where('work_schedule_id', $workScheduleId)
                    ->where('month_id', $month)
                    ->where('year', $year);
            });
        })->paginate(50);

        return $users;
    }
}
