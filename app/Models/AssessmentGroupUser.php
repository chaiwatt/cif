<?php

namespace App\Models;

use App\Models\User;
use App\Models\AssessmentGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssessmentGroupUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'assessment_group_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assessmentGroup()
    {
        return $this->belongsTo(AssessmentGroup::class, 'assessment_group_id');
    }
}
