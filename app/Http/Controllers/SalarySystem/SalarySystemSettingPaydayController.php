<?php

namespace App\Http\Controllers\SalarySystem;

use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Helpers\AddDefaultWorkScheduleAssignment;
use App\Models\EmployeeType;
use App\Models\PayDayRange;
use App\Services\UpdatedRoleGroupCollectionService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SalarySystemSettingPaydayController extends Controller
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
        $payDayRanges = PayDayRange::all();
        

        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'payDayRanges' => $payDayRanges,
            
        ]);
    }

    public function create()
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'create'
        $action = 'create';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission, viewName โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $employeeTypes = EmployeeType::all();

        return view('groups.salary-system.setting.payday.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'employeeTypes' => $employeeTypes
        ]);
    }
    public function store(Request $request)
    {
        // ตรวจสอบความถูกต้องของข้อมูลแบบฟอร์ม
        $validator = $this->validateFormData($request);

        if ($validator->fails()) {
            // ในกรณีที่ข้อมูลไม่ถูกต้อง กลับไปยังหน้าก่อนหน้าพร้อมแสดงข้อผิดพลาดและข้อมูลที่กรอก
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ดึงข้อมูลจากแบบฟอร์ม
        $name = $request->name;
        $employeeTypeId = $request->employeeType;
        $start = $request->start;
        $end = $request->end;
        $payday = $request->payday;
        PayDayRange::create([
            'name' => $name,
            'employee_type_id' => $employeeTypeId ,
            'start' => $start,
            'end' => $end,
            'payday' => $payday
        ]);

        return redirect()->route('groups.salary-system.setting.payday', [
            'message' => 'นำเข้าข้อมูลเรียบร้อยแล้ว'
        ]);
    }

    public function view($id)
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'create'
        $action = 'update';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission, viewName โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $employeeTypes = EmployeeType::all();
        $payDayRange = PayDayRange::find($id);
        

        return view('groups.salary-system.setting.payday.view', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'employeeTypes' => $employeeTypes,
            'payDayRange' => $payDayRange
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validateFormData($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ดึงข้อมูลจากแบบฟอร์ม
        $name = $request->name;
        $employeeTypeId = $request->employeeType;
        $start = $request->start;
        $end = $request->end;
        $payday = $request->payday;
        PayDayRange::find($id)->update([
            'name' => $name,
            'employee_type_id' => $employeeTypeId ,
            'start' => $start,
            'end' => $end,
            'payday' => $payday
        ]);

        return redirect()->route('groups.salary-system.setting.payday', [
            'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว'
        ]);

    }

    public function delete($id)
    {
        $payDayRange = PayDayRange::findOrFail($id);

        $this->activityLogger->log('ลบ', $payDayRange);

        $payDayRange->delete();

        return response()->json(['message' => 'รอบคำนวนเงินเดือนได้ถูกลบออกเรียบร้อยแล้ว']);
    }


    public function validateFormData($request)
    {
        // ตรวจสอบความถูกต้องของข้อมูลในฟอร์ม
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'start' => 'required|integer|between:1,31',
            'end' => 'required|integer|between:1,31',
            'payday' => 'required|integer|between:1,31',
            'employeeType' => [
                'required',
                Rule::exists(EmployeeType::class, 'id')
            ]
            
        ]);

        // ส่งกลับตัว validator
        return $validator;
    }
}
