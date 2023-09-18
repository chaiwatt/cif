<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Models\AssessmentGroup;
use App\Models\AssessmentScore;
use App\Models\AssessmentCriteria;
use App\Models\AssessmentGroupCriteria;
use App\Services\UpdatedRoleGroupCollectionService;

class AssessmentSystemSettingAssessmentGroupAssignmentController extends Controller
{
    private $updatedRoleGroupCollectionService;
    private $activityLogger;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService,ActivityLogger $activityLogger) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
        $this->activityLogger = $activityLogger;
    }
    public function index($id)
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'show'
        $action = 'show';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];

        $assessmentCriterias = AssessmentCriteria::all();
        $assessmentGroup = AssessmentGroup::find($id);
        $assessmentGroupCriterias = AssessmentGroupCriteria::where('assessment_group_id',$id)->get();
        
        
        return view('groups.assessment-system.setting.assessment-group.assignment.index', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'assessmentCriterias' => $assessmentCriterias,
            'assessmentGroup' => $assessmentGroup,
            'assessmentGroupCriterias' => $assessmentGroupCriterias
        ]);
    }
    public function create($id)
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'create'
        $action = 'create';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission, viewName โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $assessmentCriterias = AssessmentCriteria::all();
        $assessmentGroup = AssessmentGroup::find($id);
        $assessmentGroupCriterias = AssessmentGroupCriteria::where('assessment_group_id',$id)->get();
        $assessmentScores = AssessmentScore::all();

        return view('groups.assessment-system.setting.assessment-group.assignment.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'assessmentCriterias' => $assessmentCriterias,
            'assessmentGroup' => $assessmentGroup,
            'assessmentGroupCriterias' => $assessmentGroupCriterias,
            'assessmentScores' => $assessmentScores
        ]);
    }
    public function store(Request $request){
        $selectedIds = $request->criterias;
        $assessmentGroupId = $request->assessmentGroupId;

        foreach ($selectedIds as $index => $assessmentCriteriaId) {
            $assessmentScoreId = $request->assessmentScore[$index];

            AssessmentGroupCriteria::updateOrCreate(
            [
                'assessment_group_id' => $assessmentGroupId,
                'accessment_criteria_id' => $assessmentCriteriaId,
                
            ],
            [
                // Add any other fields you want to update or create
                'accessment_score_id' => $assessmentScoreId,
            ]
        );

        }

        return redirect()->route('groups.assessment-system.setting.assessment-group.assignment', ['id' => $assessmentGroupId])
            ->with('message', 'นำเข้าข้อมูลเรียบร้อยแล้ว');
    }
    public function delete($id)
    {
        $assessmentGroupCriteria = AssessmentGroupCriteria::findOrFail($id);

        $this->activityLogger->log('ลบ', $assessmentGroupCriteria);

        $assessmentGroupCriteria->delete();

        return response()->json(['message' => 'เกณฑ์การประเมินได้ถูกลบออกเรียบร้อยแล้ว']);
    }
}
