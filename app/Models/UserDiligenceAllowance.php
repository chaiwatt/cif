<?php

namespace App\Models;

use App\Models\User;
use App\Models\PaydayDetail;
use Illuminate\Database\Eloquent\Model;
use App\Models\DiligenceAllowanceClassify;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDiligenceAllowance extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'payday_detail_id',
        'diligence_allowance_classify_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function paydayDetail()
    {
        return $this->belongsTo(PaydayDetail::class, 'payday_detail_id');
    }

    public function diligenceAllowanceClassify()
    {
        return $this->belongsTo(DiligenceAllowanceClassify::class, 'diligence_allowance_classify_id');
    }
}
