<?php

namespace App\Models;

use App\Models\AssessmentGroup;
use Illuminate\Database\Eloquent\Model;
use App\Models\AssessmentGroupUserCriteria;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssessmentCriteria extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description'
    ];

    public function assessmentGroups()
    {
        return $this->belongsToMany(AssessmentGroup::class, 'assessment_group_criterias', 'accessment_criteria_id', 'assessment_group_id');
    }

    public function assessmentGroupUserCriterias()
    {
        return $this->hasMany(AssessmentGroupUserCriteria::class, 'accessment_criteria_id');
    }
}
