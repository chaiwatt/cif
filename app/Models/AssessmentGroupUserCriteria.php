<?php

namespace App\Models;

use App\Models\AssessmentCriteria;
use App\Models\AssessmentGroupCriteria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssessmentGroupUserCriteria extends Model
{
    use HasFactory;
    protected $fillable = [
        'assessment_group_id',
        'user_id',
        'accessment_criteria_id',
        'score',
    ];

    public function assessmentCriteria()
    {
        return $this->belongsTo(AssessmentCriteria::class, 'accessment_criteria_id');
    }

    public function getMultiplicationScore($assessmentCriteriaId,$assessmentGroupId)
    {
        $assessmentGroupCriteria = AssessmentGroupCriteria::where('accessment_criteria_id',$assessmentCriteriaId)
        ->where('assessment_group_id',$assessmentGroupId)->first();
        if ($assessmentGroupCriteria != null){
            return $assessmentGroupCriteria->assessmentScoreMultiplication->multiplication;
        }else{
            return null;
        }
    }
}

