<?php

namespace App\Models;

use App\Models\PaydayDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalarySummary extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee',
        'payday_detail_id',
        'company_department_id',
        'sum_salary',
        'sum_overtime',
        'sum_allowance_diligence',
        'sum_income',
        'sum_deduct',
        'sum_social_security',
        'sum_leave',
        'sum_absence'
    ];

    public function paydayDetail()
    {
        return $this->belongsTo(PaydayDetail::class);
    }
}

