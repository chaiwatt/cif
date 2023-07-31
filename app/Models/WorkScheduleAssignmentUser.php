<?php

namespace App\Models;

use App\Models\User;
use App\Models\WorkScheduleAssignment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkScheduleAssignmentUser extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'work_schedule_assignment_id',
        'user_id',
        'date_in',
        'time_in',
        'date_out',
        'time_out',
        'original_time',
        'code'
    ];

    /**
     * ความสัมพันธ์กับโมเดล WorkScheduleAssignment (การกำหนดตารางเวลางาน)
     * ผ่านการเชื่อมโยงกับโมเดล WorkScheduleAssignment (การกำหนดตารางเวลางาน)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workScheduleAssignment()
    {
        return $this->belongsTo(WorkScheduleAssignment::class);
    }


    /**
     * ความสัมพันธ์กับโมเดล User (ผู้ใช้งาน)
     * ผ่านการเชื่อมโยงกับโมเดล User (ผู้ใช้งาน)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function checkLeaveStatus($checkDate)
    {
        // Get the leaves for the current user
        $userId = $this->user_id;
        $user = User::find($userId);
        $leaves = $user->leaves;

        // Get the associated leave_details for the leaves
        $leaveDetails = $leaves->flatMap->leaveDetails;

        // Loop through the leaveDetails and check if $checkDate exists in the collection
        foreach ($leaveDetails as $leaveDetail) {
            if ($leaveDetail->from_date == $checkDate) {
                // Check if the corresponding leave status is 1 (approved)
                $correspondingLeave = $leaves->firstWhere('id', $leaveDetail->leave_id);
                if ($correspondingLeave->status == 1) {
                    return [
                        'leave' => true,
                        'approved' => true,
                        'rejected' => false
                    ];
                } elseif ($correspondingLeave->status === null) {
                    // If the status is 0, it means the leave is not approved yet
                    return [
                        'leave' => true,
                        'approved' => false,
                        'rejected' => false
                    ];
                } elseif ($correspondingLeave->status == 2) {
                    // If the status is 2, it means the leave is rejected
                    return [
                        'leave' => true,
                        'approved' => false,
                        'rejected' => true
                    ];
                }
            }
        }
        // If $checkDate was not found in the leaveDetails, return false for both leave and approved
        return [
            'leave' => false,
            'approved' => false,
            'rejected' => false
        ];
    }


}
