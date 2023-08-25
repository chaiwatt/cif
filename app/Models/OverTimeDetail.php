<?php

namespace App\Models;

use App\Models\User;
use App\Models\OverTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OverTimeDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'over_time_id',
        'user_id',
        'from_date',
        'to_date',
        'start_time',
        'end_time',
        'status',
        'approved_list'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function overTime()
    {
        return $this->belongsTo(OverTime::class);
    }
    public function getApprovalStatusForUser($userId)
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
