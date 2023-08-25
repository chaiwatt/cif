<?php

namespace App\Models;

use App\Models\DiligenceAllowance;
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

    public function diligenceAllowance()
    {
        return $this->belongsTo(DiligenceAllowance::class, 'diligence_allowance_id');
    }

}
