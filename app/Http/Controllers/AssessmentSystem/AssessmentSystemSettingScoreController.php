<?php

namespace App\Http\Controllers\AssessmentSystem;

use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Models\AssessmentScore;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\UpdatedRoleGroupCollectionService;

class AssessmentSystemSettingScoreController extends Controller
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
        $assessmentScores = AssessmentScore::all();

        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'assessmentScores' => $assessmentScores
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

        return view('groups.assessment-system.setting.score.create', [
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
        $score = $request->score;

        AssessmentScore::create([
            'score' => $score
        ]);

        return redirect()->route('groups.assessment-system.setting.score', [
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
        $assessmentScore = AssessmentScore::find($id);

        return view('groups.assessment-system.setting.score.view', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'assessmentScore' => $assessmentScore
        ]);
    }
    public function update(Request $request, $id)
    {
        
        $validator = $this->validateFormData($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $score = $request->score;

        AssessmentScore::find($id)->update([
            'score' => $score
        ]);
        return redirect()->route('groups.assessment-system.setting.score', [
            'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว'
        ]);
    }

    public function delete($id)
    {
        $assessmentScore = AssessmentScore::findOrFail($id);

        $this->activityLogger->log('ลบ', $assessmentScore);

        $assessmentScore->delete();

        return response()->json(['message' => 'คะแนนเกณฑ์การประเมินได้ถูกลบออกเรียบร้อยแล้ว']);
    }
    public function validateFormData($request)
    {
        // ตรวจสอบความถูกต้องของข้อมูลในฟอร์ม
        $validator = Validator::make($request->all(), [
            'score' => 'required|numeric'
        ]);

        // ส่งกลับตัว validator
        return $validator;
    }
}
