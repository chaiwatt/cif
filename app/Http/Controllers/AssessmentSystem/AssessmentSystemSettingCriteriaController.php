<?php

namespace App\Http\Controllers\AssessmentSystem;

use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Models\AssessmentCriteria;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\UpdatedRoleGroupCollectionService;

class AssessmentSystemSettingCriteriaController extends Controller
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
        $assessmentCriterias = AssessmentCriteria::all();

        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'assessmentCriterias' => $assessmentCriterias
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

        return view('groups.assessment-system.setting.criteria.create', [
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
        $name = $request->name;
        $description = $request->description;

        AssessmentCriteria::create([
            'name' => $name,
            'description' => $description,
        ]);

        return redirect()->route('groups.assessment-system.setting.criteria', [
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
        $assessmentCriteria = AssessmentCriteria::find($id);

        return view('groups.assessment-system.setting.criteria.view', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'assessmentCriteria' => $assessmentCriteria
        ]);
    }
    public function update(Request $request, $id)
    {
        
        $validator = $this->validateFormData($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $name = $request->name;
        $description = $request->description;

        AssessmentCriteria::find($id)->update([
            'name' => $name,
            'description' => $description,
        ]);
        return redirect()->route('groups.assessment-system.setting.criteria', [
            'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว'
        ]);
    }

    public function delete($id)
    {
        $assessmentCriteria = AssessmentCriteria::findOrFail($id);

        $this->activityLogger->log('ลบ', $assessmentCriteria);

        $assessmentCriteria->delete();

        return response()->json(['message' => 'เกณฑ์การประเมินได้ถูกลบออกเรียบร้อยแล้ว']);
    }
    public function validateFormData($request)
    {
        // ตรวจสอบความถูกต้องของข้อมูลในฟอร์ม
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required'
        ]);

        // ส่งกลับตัว validator
        return $validator;
    }
}
