<?php

namespace App\Models;

use App\Models\User;
use App\Models\IncomeDeduct;
use App\Models\AssessableType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IncomeDeductUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payday_detail_id',
        'income_deduct_id',
        'value'

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function incomeDeduct()
    {
        return $this->belongsTo(IncomeDeduct::class);
    }


}
