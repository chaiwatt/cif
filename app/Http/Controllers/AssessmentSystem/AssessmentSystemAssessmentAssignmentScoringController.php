<?php

namespace App\Http\Controllers\AssessmentSystem;

use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Models\AssessmentGroup;
use App\Http\Controllers\Controller;
use App\Models\AssessmentGroupUserCriteria;
use App\Services\UpdatedRoleGroupCollectionService;

class AssessmentSystemAssessmentAssignmentScoringController extends Controller
{
    private $updatedRoleGroupCollectionService;
    private $activityLogger;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService,ActivityLogger $activityLogger) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
        $this->activityLogger = $activityLogger;
    }
    public function index($user_id,$id)
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

        $assessmentGroupUserCriterias = AssessmentGroupUserCriteria::where('user_id',$user_id)
        ->where('assessment_group_id',$id)
        ->get();
        $assessmentGroup = AssessmentGroup::find($id);
        
        return view('groups.assessment-system.assessment.assessment.assignment.scoring.index', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'assessmentGroup' => $assessmentGroup,
            'assessmentGroupUserCriterias' => $assessmentGroupUserCriterias
        ]);
    }
}
