<?php

namespace App\Models;

use App\Models\User;
use App\Models\LeaveType;
use App\Models\UserLeaveTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserLeave extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'leave_type_id',
        'count'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function transactions()
    {
        return $this->hasMany(UserLeaveTransaction::class);
    }
    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }
}
