<?php

namespace App\Models;

use App\Models\Approver;
use App\Models\OverTimeDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OverTime extends Model
{
    use HasFactory;
    protected $fillable = [
        'approver_id',
        'name',
        'from_date',
        'to_date',
        'start_time',
        'end_time',
        'code',
        'manager_approve',
        'approved_list',
        'type',
        'manual_time',
        'hour_duration',
        'status'
    ];

    public function overtimeDetails()
    {
        return $this->hasMany(OverTimeDetail::class);
    }

    public function approver()
    {
        return $this->belongsTo(Approver::class);
    }

    // public function user()
    // {
    //     return $this->belongsTo(User::class,'manager_approve');
    // }

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
