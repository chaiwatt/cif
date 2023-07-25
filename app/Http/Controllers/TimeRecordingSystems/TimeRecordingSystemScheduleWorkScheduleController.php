<?php

namespace App\Http\Controllers\TimeRecordingSystems;

use Carbon\Carbon;
use App\Models\Shift;
use App\Models\ScheduleType;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Models\WorkScheduleUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Helpers\AddDefaultWorkScheduleAssignment;
use App\Services\UpdatedRoleGroupCollectionService;

class TimeRecordingSystemScheduleWorkScheduleController extends Controller
{
    private $updatedRoleGroupCollectionService;
    private $addDefaultWorkScheduleAssignment;
    private $activityLogger;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService, AddDefaultWorkScheduleAssignment $addDefaultWorkScheduleAssignment,ActivityLogger $activityLogger) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
        $this->addDefaultWorkScheduleAssignment = $addDefaultWorkScheduleAssignment;
        $this->activityLogger = $activityLogger;
    }
    
    public function index()
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'show'
        $action = 'show';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission, viewName โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $viewName = $roleGroupCollection['viewName'];

        // ค้นหาปีปัจจุบัน
        $currentYear = Carbon::now()->year;

        // ค้นหา workSchedules ที่ไม่อยู่ใน uncheckedIds และมีปีเป็น currentYear
        $uncheckedIds = WorkScheduleUser::where('user_id', auth()->id())
            ->pluck('work_schedule_id')
            ->toArray();
        $workSchedules = WorkSchedule::whereNotIn('id', $uncheckedIds)
            ->where('year', $currentYear)
            ->get();

        // ค้นหาปีทั้งหมดในตาราง WorkSchedule
        $years = WorkSchedule::distinct()->pluck('year');

        // ส่งค่าตัวแปรไปยัง view ตามค่า viewName
        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'workSchedules' => $workSchedules,
            'years' => $years,
        ]);

    }

    public function create()
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'create'
        $action = 'create';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];

        // ค้นหาปีปัจจุบัน
        $currentYear = Carbon::now()->year;

        // คำนวณปีถัดไป
        $nextYear = $currentYear + 1;

        // สร้าง collection ของปีที่ปัจจุบันและปีถัดไป
        $years = collect([$currentYear, $nextYear]);

        // ค้นหา shift ทั้งหมด
        $shifts = Shift::all();

        $scheduleTypes = ScheduleType::all();

        // ส่งค่าตัวแปรไปยัง view 'groups.time-recording-system.schedulework.schedule.create'
        return view('groups.time-recording-system.schedulework.schedule.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'years' => $years,
            'shifts' => $shifts,
            'scheduleTypes' => $scheduleTypes
        ]);

    }

    public function store(Request $request)
    {
        // ตรวจสอบข้อมูลที่ส่งมาตรงกับเงื่อนไขที่กำหนดใน validateFormData
        $validator = $this->validateFormData($request);

        // ถ้าการตรวจสอบไม่ผ่าน
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // สร้างตัวแปร WorkSchedule และกำหนดค่า name, description, year จากข้อมูลที่ส่งมา
        $workSchedule = new WorkSchedule();
        $workSchedule->name = $request->name;
        $workSchedule->description = $request->description;
        $workSchedule->year = $request->year;
        $workSchedule->schedule_type_id = $request->schedule_type;
        $workSchedule->save();

        // ดึง shiftIds จากข้อมูลที่ส่งมา
        $shiftIds = $request->shift; 
        $result = [];

        // สร้าง array ของ shiftIds ที่ติดต่อกันเพื่อใช้ในการกำหนด shifts ของ workSchedule
        foreach ($shiftIds as $shiftId) {
            $result = array_merge($result, range($shiftId, $shiftId + 2));
        }

        // ทำการแนบ shifts กับ workSchedule
        $workSchedule->shifts()->attach($result);

        // บันทึกกิจกรรมลงใน activity log
        $this->activityLogger->log('เพิ่ม', $workSchedule);
                
        // เพิ่มการกำหนดงานเริ่มต้นใน WorkScheduleAssignment
        $this->addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule, $request->year);

        // ทำการ redirect ไปยัง route 'groups.time-recording-system.schedulework.schedule'
        return redirect()->route('groups.time-recording-system.schedulework.schedule');

    }

    public function view($id)
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'update'
        $action = 'update';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];

        // ค้นหา workSchedule จาก id ที่ระบุ หากไม่พบจะเกิด exception
        $workSchedule = WorkSchedule::findOrFail($id);

        // ค้นหาปีปัจจุบัน
        $currentYear = Carbon::now()->year;

        // คำนวณปีถัดไป
        $nextYear = $currentYear + 1;

        // สร้าง collection ของปีที่ปัจจุบันและปีถัดไป
        $years = collect([$currentYear, $nextYear]);

        // ค้นหา shift ทั้งหมด
        $shifts = Shift::all();

        $scheduleTypes = ScheduleType::all();

        // ส่งค่าตัวแปรไปยัง view 'groups.time-recording-system.schedulework.schedule.view'
        return view('groups.time-recording-system.schedulework.schedule.view', [
            'groupUrl' => $groupUrl,
            'workSchedule' => $workSchedule,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'years' => $years,
            'shifts' => $shifts,
            'scheduleTypes' => $scheduleTypes,
        ]);

    }
    public function update(Request $request, $id)
    {
        // ตรวจสอบข้อมูลที่ส่งมาตรงกับเงื่อนไขที่กำหนดใน validateFormData
        $validator = $this->validateFormData($request);

        // ถ้าการตรวจสอบไม่ผ่าน
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ดึงข้อมูลที่ต้องการอัปเดตจาก request
        $name = $request->name;
        $description = $request->description ?? null;
        $year = $request->year;
        $shiftIds = $request->shift; 

        $result = [];

        // สร้าง array ของ shiftIds ที่ติดต่อกันเพื่อใช้ในการกำหนด shifts ของ workSchedule
        foreach ($shiftIds as $shiftId) {
            $result = array_merge($result, range($shiftId, $shiftId + 2));
        }

        // ค้นหา workSchedule จาก id ที่ระบุ หากไม่พบจะเกิด exception
        $workSchedule = WorkSchedule::findOrFail($id);

        // ลบ shifts ที่ไม่อยู่ใน result ออกจาก workSchedule
        $workSchedule->shifts()->whereNotIn('shift_id', $result)->detach();

        // แนบ shifts ใหม่กับ workSchedule
        $workSchedule->shifts()->attach($result);

        // บันทึกกิจกรรมลงใน activity log
        $this->activityLogger->log('อัปเดต', $workSchedule);

        // อัปเดตข้อมูลใน workSchedule
        $workSchedule->update([
            'name' => $name,
            'description' => $description,
            'year' => $year,
            'schedule_type_id' => $request->schedule_type
        ]);

        // ทำการ redirect ไปยัง route 'groups.time-recording-system.schedulework.schedule'
        return redirect()->route('groups.time-recording-system.schedulework.schedule');


    }
   
    public function delete($id)
    { 
        // กำหนดค่าตัวแปร $action ให้เป็น 'delete'
        $action = 'delete';
        
        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection โดยใช้ค่า $action
        $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);

        // ค้นหา workSchedule จาก id ที่ระบุ หากไม่พบจะเกิด exception
        $workSchedule = WorkSchedule::findOrFail($id);

        // บันทึกกิจกรรมลงใน activity log
        $this->activityLogger->log('ลบ', $workSchedule);

        // ลบ workSchedule
        $workSchedule->delete();

        // ส่งคำตอบกลับในรูปแบบ JSON
        return response()->json(['message' => 'ตารางทำงานได้ถูกลบออกเรียบร้อยแล้ว']);

    }

    public function search(Request $request)
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'show'
        $action = 'show';
        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $permission = $roleGroupCollection['permission'];

        // ค้นหา workSchedules ที่มีปีเท่ากับค่า currentYear ที่ส่งมาใน request
        $currentYear = $request->data;
        $workSchedules = WorkSchedule::where('year', $currentYear)->get();

        // ส่งค่าตัวแปรไปยัง view 'groups.time-recording-system.schedulework.schedule.table-render.schedule-table'
        return view('groups.time-recording-system.schedulework.schedule.table-render.schedule-table', [
            'workSchedules' => $workSchedules,
            'permission' => $permission
        ])->render();

    }

    function validateFormData($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'shift' => 'required|array|min:1'
        ]);
        $validator->messages()->add('shift.required', 'กรุณาเลือกกะการทำงาน');
        return $validator;
    }
}
