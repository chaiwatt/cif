<?php

namespace App\Models;

use App\Models\User;
use App\Models\LeaveType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveIncrement extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'leave_type_id',
        'type',
        'months',
        'quantity'
    ];

    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }

    public function isChecked($monthId)
    {
        $monthsData = json_decode($this->months, true);

        foreach ($monthsData as $month) {
            if ($month['monthId'] == $monthId && $month['isChecked'] == 1) {
                return true;
            }
        }

        return false;
    }


}
