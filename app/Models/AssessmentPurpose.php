<?php

namespace App\Models;

use App\Models\Assessment;
use App\Models\AssessmentGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssessmentPurpose extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function assessmentGroups()
    {
        return $this->hasMany(AssessmentGroup::class);
    }
}
