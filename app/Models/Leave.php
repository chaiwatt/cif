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
        'duration',
        'approved_list',
        'attachment',
        'manager_approve'
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
    public function getLeaderApprovalStatus($userId)
    {
        $approvedList = json_decode($this->approved_list, true);
        if (is_array($approvedList)) {
            foreach ($approvedList as $item) {
                if (isset($item['user_id']) && $item['user_id'] == $userId) {
                    return $item['status'];
                }
            }
        }
        return null; // Return null if the user ID is not found in the 'approved_list'
    }
    
}
