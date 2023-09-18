<?php

namespace App\Models;

use App\Models\UserLeave;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserLeaveTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_leave_id',
        'month_id'
    ];
    public function leave()
    {
        return $this->belongsTo(UserLeave::class);
    }
}
