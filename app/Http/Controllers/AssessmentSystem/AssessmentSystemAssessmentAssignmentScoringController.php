<?php

namespace App\Http\Controllers\AssessmentSystem;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserPayday;
use App\Models\PaydayDetail;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Models\AssessmentGroup;
use App\Models\AssessmentScore;
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
        
        $assessmentScores = AssessmentScore::get();
        $user = User::find($user_id);

        $assessmentGroupUserCriterias = AssessmentGroupUserCriteria::where('user_id',$user_id)
        ->where('assessment_group_id',$id)
        ->get();
        $assessmentGroup = AssessmentGroup::find($id);
        
        $year = Carbon::now()->year;
        $paydayIds = UserPayday::where('user_id', $user_id)
        ->whereHas('payday', function ($query) use ($year) {
            $query->where('year',$year)
                    ->where('type',1);
                        
        })
        ->pluck('payday_id')->toArray();
        
        // $user = User::find(782);
        $datas = [];
        foreach ($paydayIds as $paydayId){
            $paydayDetails = PaydayDetail::where('payday_id',$paydayId)->orderBy('start_date')->get();
            foreach($paydayDetails as $paydayDetail ){
                $userSummary = $user->salarySummary($paydayDetail->id);
                if ($userSummary['workHour'] != null || $userSummary['absentCountSum'] != null ||$userSummary['leaveCountSum'] != null || $userSummary['earlyHour'] != null || $userSummary['lateHour'] != null){
                    $data = [
                        'paydayDetail' => $paydayDetail,
                        'workHours' => $userSummary['workHour'],
                        'absentCounts' => $userSummary['absentCountSum'],
                        'leaveCounts' => $userSummary['leaveCountSum'],
                        'earlyHours' => $userSummary['earlyHour'],
                        'lateHours' => $userSummary['lateHour']
                    ];
                    $datas[] = $data;
                }    
            }
        }
        
        return view('groups.assessment-system.assessment.assessment.assignment.scoring.index', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'assessmentGroup' => $assessmentGroup,
            'assessmentGroupUserCriterias' => $assessmentGroupUserCriterias,
            'assessmentScores' => $assessmentScores,
            'user' => $user,
            'datas' => $datas
        ]);
    }

    public function summary($user_id,$id){
        // กำหนดค่าตัวแปร $action ให้เป็น 'show'
        $action = 'show';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        
        $maxAssessmentScore = AssessmentScore::max('score');
        
        $user = User::find($user_id);

        $assessmentGroupUserCriterias = AssessmentGroupUserCriteria::where('user_id',$user_id)
        ->where('assessment_group_id',$id)
        ->get();
        $assessmentGroup = AssessmentGroup::find($id);
        
        return view('groups.assessment-system.assessment.assessment.assignment.scoring.summary', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'assessmentGroup' => $assessmentGroup,
            'assessmentGroupUserCriterias' => $assessmentGroupUserCriterias,
            'maxAssessmentScore' => $maxAssessmentScore,
            'user' => $user
        ]);
    }
    public function updateScore(Request $request)
    {
        $assessmentGroupUserCriteriaIds = $request->assessmentGroupUserCriteriaId;
        $assessmentScoreMultiplications = $request->assessmentScoreMultiplication;
        $assessmentScores = $request->assessmentScore;
        $assessmentGroupId = $request->assessmentGroupId;
        $userId = $request->userId;
        foreach ($assessmentGroupUserCriteriaIds as $index => $assessmentGroupUserCriteriaId) {
            $score = $assessmentScores[$index];
            AssessmentGroupUserCriteria::find($assessmentGroupUserCriteriaId)->update(['score' => $score]);
        }

        return redirect()->route('groups.assessment-system.assessment.assessment.assignment',['id' => $assessmentGroupId ]);

    }
}
