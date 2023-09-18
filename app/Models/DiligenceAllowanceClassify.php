<?php

namespace App\Models;

use App\Models\DiligenceAllowance;
use App\Models\UserDiligenceAllowance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiligenceAllowanceClassify extends Model
{
    use HasFactory;
    protected $fillable = [
        'diligence_allowance_id',
        'level',
        'cost'
    ];
    
    public function diligenceAllowances()
    {
        return $this->hasMany(UserDiligenceAllowance::class, 'diligence_allowance_classify_id');
    }

}
