<?php

namespace App\Http\Controllers\TimeRecordingSystems;

use App\Models\User;
use App\Models\UserGroup;
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

        // กำหนดค่าตัวแปร $action ให้เป็น 'show'
        $action = 'show';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];

        // ค้นหาข้อมูล WorkSchedule จาก scheduleId และเก็บในตัวแปร $workSchedule
        $workSchedule = WorkSchedule::find($scheduleId);

        // เรียกใช้งานฟังก์ชัน getUsersByWorkScheduleAssignment เพื่อดึงข้อมูลผู้ใช้ที่เกี่ยวข้องกับ WorkScheduleAssignment
        $users = $this->getUsersByWorkScheduleAssignment($scheduleId, $monthId, $year)->paginate(20);

        $userGroups = UserGroup::all();

        // ส่งค่าตัวแปรไปยัง view 'groups.time-recording-system.schedulework.schedule.assignment.user.index'
        return view('groups.time-recording-system.schedulework.schedule.assignment.user.index', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'users' => $users,
            'workSchedule' => $workSchedule,
            'year' => $year,
            'monthId' => $monthId,
            'userGroups' => $userGroups,
        ]);

    }

    public function create($scheduleId,$year,$monthId)
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'create'
        $action = 'create';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];

        // ค้นหาข้อมูล WorkSchedule จาก scheduleId และเก็บในตัวแปร $workSchedule
        $workSchedule = WorkSchedule::find($scheduleId);

        // ค้นหาข้อมูลผู้ใช้ทั้งหมดและแบ่งหน้าผลลัพธ์ที่แสดงให้แสดงผลเฉพาะ 20 รายการต่อหน้า
        $users = User::paginate(20);

        // ส่งค่าตัวแปรไปยัง view 'groups.time-recording-system.schedulework.schedule.assignment.user.create'
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
        // กำหนดเงื่อนไขการตรวจสอบข้อมูล
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

        // ถ้าการตรวจสอบไม่ผ่าน
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $workScheduleId = $request->workScheduleId;
            $year = $request->year;
            $month = $request->month;
            
            $selectedUsers = $request->users;

            $users = User::whereIn('id', $selectedUsers)->get();

            foreach ($users as $user) {
                // ค้นหา WorkScheduleAssignment ที่ตรงกับ workScheduleId, month, year และเก็บในตัวแปร $workScheduleAssignments
                $workScheduleAssignments = WorkScheduleAssignment::where('work_schedule_id', $workScheduleId)
                    ->where('month_id', $month)
                    ->where('year', $year)
                    ->get();

                // ลบการกำหนดงานใน WorkScheduleAssignment ของผู้ใช้นั้น
                $user->detachWorkScheduleAssignments($workScheduleId, $month, $year);

                // กำหนดการกำหนดงานใหม่ใน WorkScheduleAssignment ของผู้ใช้นั้น
                $user->attachWorkScheduleAssignments($workScheduleAssignments);
            }
            
            // กำหนด URL สำหรับ redirect
            $url = "groups/time-recording-system/schedulework/schedule/assignment/user/{$workScheduleId}/year/{$year}/month/{$month}";
            
            // ทำการ redirect ไปยัง URL ที่กำหนด
            return redirect()->to($url);
        }

    }

    public function importUserGroup(Request $request)
    {
        $workScheduleId = $request->workScheduleId;
        $userGroupId = $request->userGroupId;
        $month = $request->month;
        $year = $request->year;
        $userGroup = UserGroup::findOrFail($userGroupId);
        $users = $userGroup->users;

        foreach ($users as $user) {
            // ค้นหา WorkScheduleAssignment ที่ตรงกับ workScheduleId, month, year และเก็บในตัวแปร $workScheduleAssignments
            $workScheduleAssignments = WorkScheduleAssignment::where('work_schedule_id', $workScheduleId)
                ->where('month_id', $month)
                ->where('year', $year)
                ->get();

            // ลบการกำหนดงานใน WorkScheduleAssignment ของผู้ใช้นั้น
            $user->detachWorkScheduleAssignments($workScheduleId, $month, $year);

            // กำหนดการกำหนดงานใหม่ใน WorkScheduleAssignment ของผู้ใช้นั้น
            $user->attachWorkScheduleAssignments($workScheduleAssignments);
        }
        return response()->json($users);

    }

    /**
     * ค้นหาพนักงงาน
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        // รับค่า queryInput จาก request
        $queryInput = $request->data;
   
        // ค้นหา searchFields จากตาราง SearchField ที่เกี่ยวข้องกับตาราง users และมีสถานะเป็น 1
        $searchFields = SearchField::where('table', 'users')->where('status', 1)->get();

        // สร้าง query ของตาราง users
        $query = User::query();

        foreach ($searchFields as $field) {
            $fieldName = $field['field'];
            $fieldType = $field['type'];

            if ($fieldType === 'foreign') {
                // ค้นหาข้อมูลที่เกี่ยวข้องจากตาราง foreign และตรวจสอบว่ามีชื่อตรงกับ queryInput หรือไม่
                $query->orWhereHas($fieldName, function ($query) use ($fieldName, $queryInput) {
                    $query->where('name', 'like', "%{$queryInput}%");
                });
            } else {
                // ค้นหาข้อมูลในฟิลด์ของตาราง users และตรวจสอบว่ามีค่าตรงกับ queryInput หรือไม่
                $query->orWhere($fieldName, 'like', "%{$queryInput}%");
            }
        }

        // ค้นหาผู้ใช้และแบ่งหน้าผลลัพธ์เป็นรายการที่แสดงให้แสดงผลเฉพาะ 50 รายการต่อหน้า
        $users = $query->paginate(50);

        // ส่งผลลัพธ์การค้นหาไปยัง view 'groups.time-recording-system.schedulework.schedule.assignment.user.table-render.user-table' เพื่อทำการ render ตารางผู้ใช้
        return view('groups.time-recording-system.schedulework.schedule.assignment.user.table-render.user-table', ['users' => $users])->render();

    }

    public function delete($workScheduleId,$year,$monthId, $userId)
    {
        // ค้นหาข้อมูลผู้ใช้จาก userId
        $user = User::find($userId);
        // ถ้าพบข้อมูลผู้ใช้
        if ($user) {
            // ลบการกำหนดงานใน WorkScheduleAssignment ของผู้ใช้ใน workScheduleId, monthId, year
            $user->workScheduleAssignments()
                ->where('work_schedule_id', $workScheduleId)
                ->where('month_id', $monthId)
                ->where('year', $year)
                ->detach();
        }

        // กำหนด URL สำหรับ redirect
        $url = "groups/time-recording-system/schedulework/schedule/assignment/user/{$workScheduleId}/year/{$year}/month/{$monthId}";

        // ทำการ redirect ไปยัง URL ที่กำหนด
        return redirect()->to($url);

    }
    public function getUsersByWorkScheduleAssignment($workScheduleId, $month, $year)
    {
        // ค้นหาผู้ใช้ที่มี workScheduleAssignmentUsers ที่ตรงกับ workScheduleId, month, year
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
