<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SararySummary extends Model
{
    use HasFactory;
    protected $fillable = [
        'payday_detail_id',
        'total_salary',
        'total_overtime',
        'total_diligence_allowance',
        'total_deduct',
        'total_income',
    ];
}
