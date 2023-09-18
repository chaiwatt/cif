<?php

namespace App\Models;

use App\Models\Month;
use App\Models\Payday;
use App\Models\UserDiligenceAllowance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaydayDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'payday_id',
        'month_id',
        'start_date',
        'end_date',
        'payment_date'
    ];
    public function month()
    {
        return $this->belongsTo(Month::class);
    }
    public function payday()
    {
        return $this->belongsTo(Payday::class);
    }
    public function diligenceAllowances()
    {
        return $this->hasMany(UserDiligenceAllowance::class, 'payday_detail_id');
    }
}
