<?php

namespace App\Http\Controllers\AssessmentSystem;

use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\AssessmentScoreMultiplication;
use App\Services\UpdatedRoleGroupCollectionService;

class AssessmentSystemSettingMultiplicationController extends Controller
{
    private $updatedRoleGroupCollectionService;
    private $activityLogger;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService,ActivityLogger $activityLogger) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
        $this->activityLogger = $activityLogger;
    }
    public function index()
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'show'
        $action = 'show';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $viewName = $roleGroupCollection['viewName'];
        $assessmentScoreMultiplications = AssessmentScoreMultiplication::all();

        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'assessmentScoreMultiplications' => $assessmentScoreMultiplications
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

        return view('groups.assessment-system.setting.multiplication.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission
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
        $multiplication = $request->multiplication;

        AssessmentScoreMultiplication::create([
            'multiplication' => $multiplication
        ]);

        return redirect()->route('groups.assessment-system.setting.multiplication', [
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
        $assessmentScoreMultiplication = AssessmentScoreMultiplication::find($id);

        return view('groups.assessment-system.setting.multiplication.view', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'assessmentScoreMultiplication' => $assessmentScoreMultiplication
        ]);
    }
    public function update(Request $request, $id)
    {
        
        $validator = $this->validateFormData($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $multiplication = $request->multiplication;

        AssessmentScoreMultiplication::find($id)->update([
            'multiplication' => $multiplication
        ]);
        return redirect()->route('groups.assessment-system.setting.multiplication', [
            'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว'
        ]);
    }

    public function delete($id)
    {
        $assessmentScoreMultiplication = AssessmentScoreMultiplication::findOrFail($id);

        $this->activityLogger->log('ลบ', $assessmentScoreMultiplication);

        $assessmentScoreMultiplication->delete();

        return response()->json(['message' => 'ตัวคูณคะแนนเกณฑ์การประเมินได้ถูกลบออกเรียบร้อยแล้ว']);
    }
    public function validateFormData($request)
    {
        // ตรวจสอบความถูกต้องของข้อมูลในฟอร์ม
        $validator = Validator::make($request->all(), [
            'multiplication' => 'required|numeric'
        ]);

        // ส่งกลับตัว validator
        return $validator;
    }
}
