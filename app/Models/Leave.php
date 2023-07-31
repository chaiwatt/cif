<?php

namespace App\Models;

use App\Models\User;
use App\Models\LeaveType;
use App\Models\LeaveDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Leave extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'leave_type_id',
        'from_date',
        'to_date',
        'status',
        'half_day',
        'half_day_type'
    ];

    public function leaveDetails()
    {
        return $this->hasMany(LeaveDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }
}
