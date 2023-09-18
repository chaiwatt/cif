<?php

namespace App\Models;

use App\Models\AssessmentPurpose;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assessment extends Model
{
    use HasFactory;

    public function purpose()
    {
        return $this->belongsTo(AssessmentPurpose::class);
    }
}
