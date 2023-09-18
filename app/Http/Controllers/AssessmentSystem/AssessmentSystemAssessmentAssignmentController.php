<?php

namespace App\Http\Controllers\AssessmentSystem;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Models\AssessmentGroup;
use App\Http\Controllers\Controller;
use App\Models\AssessmentGroupCriteria;
use App\Models\AssessmentGroupUserCriteria;
use App\Services\UpdatedRoleGroupCollectionService;

class AssessmentSystemAssessmentAssignmentController extends Controller
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

        // $assessmentGroups = AssessmentGroup::find($id);
        $assessmentGroup = AssessmentGroup::find($id);
        $userIds = $assessmentGroup->assessmentGroupUsers()->with('user')->pluck('user_id')->toArray();
        // dd($users);
        $users = User::whereIn('id',$userIds)->get();

        return view('groups.assessment-system.assessment.assessment.assignment.index', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'assessmentGroup' => $assessmentGroup,
            'users' => $users
        ]);
    }

    public function importUser(Request $request)
    {
        $employeeNos = $request->data['employeeNos'];
        $assessmentGroupId = $request->data['assessmentGroupId'];
        // dd($employeeNos,$assessmentGroupId);
        $assessmentGroup = AssessmentGroup::findOrFail($assessmentGroupId);
        $users = User::whereIn('employee_no', $employeeNos)->get();
        $assessmentGroupCriterias = AssessmentGroupCriteria::where('assessment_group_id',$assessmentGroupId)->get();
        foreach ($users as $user) {
            if (!$assessmentGroup->assessmentGroupUsers()->where('user_id', $user->id)->exists()) {
                $assessmentGroup->assessmentGroupUsers()->create(['user_id' => $user->id]);
            }
            
            foreach ($assessmentGroupCriterias as $assessmentGroupCriteria){
                $assessmentGroupUserCriteria = AssessmentGroupUserCriteria::where('assessment_group_id',$assessmentGroupId)
                ->where('user_id',$user->id)
                ->where('accessment_criteria_id',$assessmentGroupCriteria->accessment_criteria_id)
                ->first();
                if ($assessmentGroupUserCriteria == null){
                    AssessmentGroupUserCriteria::create([
                        'assessment_group_id' => $assessmentGroupId,
                        'user_id' => $user->id,
                        'accessment_criteria_id' => $assessmentGroupCriteria->accessment_criteria_id,
                    ]);
                }
            }
        }

    }
}
