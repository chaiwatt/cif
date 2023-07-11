<?php

namespace App\Http\Controllers\TimeRecordingSystems;

use App\Models\User;
use App\Models\SearchField;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WorkScheduleAssignment;
use Illuminate\Support\Facades\Validator;
use App\Helpers\AddDefaultWorkScheduleAssignment;
use App\Services\UpdatedRoleGroupCollectionService;

class TimeRecordingSystemScheduleWorkScheduleAssignmentUserController extends Controller
{
    private $updatedRoleGroupCollectionService;
    private $addDefaultWorkScheduleAssignment;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService, AddDefaultWorkScheduleAssignment $addDefaultWorkScheduleAssignment) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
        $this->addDefaultWorkScheduleAssignment = $addDefaultWorkScheduleAssignment;
    }
    public function index($scheduleId,$year,$monthId)
    {
        $action = 'show';
        $groupUrl = strval(session('groupUrl'));
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $workSchedule = WorkSchedule::find($scheduleId);
        $users = $this->getUsersByWorkScheduleAssignment($scheduleId, $monthId, $year)->paginate(20);

        return view('groups.time-recording-system.schedulework.schedule.assignment.user.index', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'users' => $users,
            'workSchedule' => $workSchedule,
            'year' => $year,
            'monthId' => $monthId
        ]);
    }

    public function create($scheduleId,$year,$monthId)
    {
        $action = 'create';
        $groupUrl = strval(session('groupUrl'));
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $workSchedule = WorkSchedule::find($scheduleId);
        $users = User::paginate(20);
        return view('groups.time-recording-system.schedulework.schedule.assignment.user.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'users' => $users,
            'workSchedule' => $workSchedule,
            'year' => $year,
            'monthId' => $monthId
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'workScheduleId' => 'required',
            'year' => 'required',
            'month' => 'required',
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
        ], [
            'workScheduleId.required' => 'กรุณากรอกข้อมูล Work Schedule ID',
            'year.required' => 'กรุณากรอกข้อมูลปี',
            'month.required' => 'กรุณากรอกข้อมูลเดือน',
            'users.required' => 'กรุณาเลือกพนักงาน',
            'users.array' => 'ข้อมูลผู้ใช้ต้องเป็นรูปแบบของอาร์เรย์',
            'users.*.exists' => 'ผู้ใช้บางรายที่เลือกไม่มีอยู่ในระบบ',
        ]);

        if ($validator->fails()) {
            // Handle validation failure, return error response, or perform any necessary actions
            return redirect()->back()->withErrors($validator)->withInput();
            // ...
        } else {
            $workScheduleId = $request->workScheduleId;
            $year = $request->year;
            $month = $request->month;
            
            $selectedUsers = $request->users;
        
            $users = User::whereIn('id',$selectedUsers)->get();

            foreach($users as $user)
            {
                $workScheduleAssignments = WorkScheduleAssignment::where('work_schedule_id',$workScheduleId)->where('month_id',$month)->where('year',$year)->get();
                $user->detachWorkScheduleAssignments($workScheduleId, $month, $year); 
                $user->attachWorkScheduleAssignments($workScheduleAssignments);
            }
            
            $url = "groups/time-recording-system/schedulework/schedule/assignment/user/{$workScheduleId}/year/{$year}/month/{$month}";
            return redirect()->to($url);
        }
    }

    /**
     * ค้นหาพนักงงาน
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $queryInput = $request->data;
   
        $searchFields = SearchField::where('table', 'users')->where('status', 1)->get();

        $query = User::query();

        foreach ($searchFields as $field) {
            $fieldName = $field['field'];
            $fieldType = $field['type'];

            if ($fieldType === 'foreign') {
                $query->orWhereHas($fieldName, function ($query) use ($fieldName, $queryInput) {
                    $query->where('name', 'like', "%{$queryInput}%");
                });
            } else {
                $query->orWhere($fieldName, 'like', "%{$queryInput}%");
            }
        }

        $users = $query->paginate(50);
       
        return view('groups.time-recording-system.schedulework.schedule.assignment.user.table-render.user-table', ['users' => $users])->render();
    }

    public function delete($workScheduleId,$year,$monthId, $userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->workScheduleAssignments()
                ->where('work_schedule_id', $workScheduleId)
                ->where('month_id', $monthId)
                ->where('year', $year)
                ->detach();
        }

        $url = "groups/time-recording-system/schedulework/schedule/assignment/user/{$workScheduleId}/year/{$year}/month/{$monthId}";
        return redirect()->to($url);
    }
    public function getUsersByWorkScheduleAssignment($workScheduleId, $month, $year)
    {
        $users = User::whereHas('workScheduleAssignmentUsers', function ($query) use ($workScheduleId, $month, $year) {
            $query->whereHas('workScheduleAssignment', function ($query) use ($workScheduleId, $month, $year) {
                $query->where('work_schedule_id', $workScheduleId)
                    ->where('month_id', $month)
                    ->where('year', $year);
            });
        });

        return $users;
    }
}
