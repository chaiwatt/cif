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
        // กำหนดค่าตัวแปร $action ให้เป็น 'show'
        $action = 'show';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];

        // ค้นหาผู้ใช้ตามการกำหนดงานเรียกงานใน workScheduleId, monthId, year
        $users = $this->getUsersByWorkScheduleAssignment($workScheduleId, $monthId, $year);

        // ค้นหา workSchedule จาก workScheduleId
        $workSchedule = WorkSchedule::find($workScheduleId);

        // ค้นหาเดือนที่ monthId
        $month = Month::find($monthId);

        // ส่งค่าตัวแปรไปยัง view 'groups.time-recording-system.schedulework.time-recording.import.index'
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
        // ดึงค่า month, year, workScheduleId, importUsers จาก request
        $month = $request->data['month'];
        $year = $request->data['year'];
        $importUsers = $request->data['batch'];

        // หา AC-No ที่ไม่ซ้ำกันใน importUsers
        $distinctACNos = array_unique(array_column($importUsers, 'AC-No'));
        $distinctACNos = array_values($distinctACNos);

        // ค้นหาผู้ใช้ที่มี employee_no เป็น distinctACNos[0]
        $user = User::where('employee_no', $distinctACNos[0])->first();

        // วนลูปตาม importUsers
        foreach ($importUsers as $importUser) {
            // แปลงค่า Date เป็น Carbon object
            $date = Carbon::parse($importUser['Date']);
            $day = $date->day;
            $month = $date->month;
            $year = $date->year;
            $employeeNo = $importUser['AC-No'];

            // ค้นหาผู้ใช้ที่มี employee_no เป็น $employeeNo
            $user = User::where('employee_no', $employeeNo)->first();

            // ค้นหา workScheduleAssignmentUser ตามเงื่อนไข day, month, year
            $workScheduleAssignmentUser = $user->getWorkScheduleAssignmentUserByConditions($day, $month, $year)->first();
            
            // ถ้าพบ workScheduleAssignmentUser
            if ($workScheduleAssignmentUser) {
                // อัปเดตค่า time_in, time_out เป็น '00:00:00'
                $workScheduleAssignmentUser->update([
                    'time_in' => '00:00:00',
                    'time_out' => '00:00:00',
                ]);
            }
        }

        // ส่งคำตอบกลับในรูปแบบ JSON พร้อมกับ importUsers
        return response()->json($importUsers);

    }

    public function getUsersByWorkScheduleAssignment($workScheduleId, $month, $year)
    {
        // ค้นหาผู้ใช้ที่มีการกำหนดงานเรียกงานใน workScheduleId, month, year
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
