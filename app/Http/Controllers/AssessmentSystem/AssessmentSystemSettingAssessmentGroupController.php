<?php

namespace App\Http\Controllers\AssessmentSystem;

use App\Models\Assessment;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Models\AssessmentGroup;
use App\Models\AssessmentPurpose;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\UpdatedRoleGroupCollectionService;

class AssessmentSystemSettingAssessmentGroupController extends Controller
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
        $assessmentGroups = AssessmentGroup::all();
        
        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'assessmentGroups' => $assessmentGroups
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
        $assessmentPurposes = AssessmentPurpose::all();

        return view('groups.assessment-system.setting.assessment-group.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'assessmentPurposes' => $assessmentPurposes,
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
        $purpose = $request->purpose;

        AssessmentGroup::create([
            'name' => $name,
            'assessment_purpose_id' => $purpose,
        ]);

        return redirect()->route('groups.assessment-system.setting.assessment-group', [
            'message' => 'นำเข้าข้อมูลเรียบร้อยแล้ว'
        ]);
    }
    public function view($id)
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'create'
        $action = 'create';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission, viewName โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $assessmentPurposes = AssessmentPurpose::all();
        $assessmentGroup = AssessmentGroup::find($id);

        return view('groups.assessment-system.setting.assessment-group.view', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'assessmentPurposes' => $assessmentPurposes,
            'assessmentGroup' => $assessmentGroup
        ]);
    }
    public function update(Request $request,$id)
    {
        // ตรวจสอบความถูกต้องของข้อมูลแบบฟอร์ม
        $validator = $this->validateFormData($request);
        if ($validator->fails()) {
            // ในกรณีที่ข้อมูลไม่ถูกต้อง กลับไปยังหน้าก่อนหน้าพร้อมแสดงข้อผิดพลาดและข้อมูลที่กรอก
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ดึงข้อมูลจากแบบฟอร์ม
        $name = $request->name;
        $purpose = $request->purpose;

        AssessmentGroup::find($id)->update([
            'name' => $name,
            'assessment_purpose_id' => $purpose,
        ]);

        return redirect()->route('groups.assessment-system.setting.assessment-group', [
            'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว'
        ]);
    }
    public function delete($id)
    {
        $assessmentGroup = AssessmentGroup::findOrFail($id);

        $this->activityLogger->log('ลบ', $assessmentGroup);

        $assessmentGroup->delete();

        return response()->json(['message' => 'กลุ่มการประเมินได้ถูกลบออกเรียบร้อยแล้ว']);
    }
    public function validateFormData($request)
    {
        // ตรวจสอบความถูกต้องของข้อมูลในฟอร์ม
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'purpose' => 'required'
        ]);

        // ส่งกลับตัว validator
        return $validator;
    }
    
}
