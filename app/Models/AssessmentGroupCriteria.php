<?php

namespace App\Models;

use App\Models\AssessmentScore;
use App\Models\AssessmentCriteria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssessmentGroupCriteria extends Model
{
    use HasFactory;
    protected $fillable = [
        'assessment_group_id',
        'accessment_score_id',
        'accessment_criteria_id',
        
    ];
    public function assessmentCriteria()
    {
        return $this->belongsTo(AssessmentCriteria::class, 'accessment_criteria_id');
    }
    public function assessmentScore()
    {
        return $this->belongsTo(AssessmentScore::class, 'accessment_score_id');
    }
    public function assessmentGroup()
    {
        return $this->belongsTo(AssessmentGroup::class, 'accessment_group_id');
    }

}
