<?php

namespace App\Models;


use App\Models\AssessmentCriteria;
use App\Models\AssessmentGroupUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssessmentGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'assessment_purpose_id'
    ];

    public function assessmentPurpose()
    {
        return $this->belongsTo(AssessmentPurpose::class);
    }
    public function assessmentCriterias()
    {
        return $this->belongsToMany(AssessmentCriteria::class, 'assessment_group_criterias', 'assessment_group_id', 'accessment_criteria_id');
    }
    public function assessmentGroupUsers()
    {
        return $this->hasMany(AssessmentGroupUser::class, 'assessment_group_id');
    }
}
