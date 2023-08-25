<?php

namespace App\Models;

use Carbon\Carbon;
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
            $fromDate = Carbon::parse($leaveDetail->from_date)->format('Y-m-d');
            if ($fromDate == $checkDate) {
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


    public function getAttachmentForDate() {
        $startTime = WorkScheduleAssignmentUser::findOrFail($this->id)
            ->workScheduleAssignment
            ->shift
            ->start;
    
        $date = $this->date_in;

        $combinedDateTime = "$date $startTime";

        $leave = Leave::where('user_id', $this->user_id)
            ->where(function ($query) use ($combinedDateTime) {
                $query->where('from_date', '<=', $combinedDateTime)
                    ->where('to_date', '>=', $combinedDateTime);
            })
            ->first();

        if ($leave) {
            return $leave->attachment;
        } else {
            return null;
        }
    }

    public function getWorkHour()
    {
        // $result = collect([
        //     'workHour' => null,
        //     'leaveCount' => null,
        //     'absentCount' => null,
        //     'lateMinute' => null,
        //     'earlyMinute' => null,
        // ]);
        $workHour = 0;
        $lateMinute = 0;
        $earlyMinute = 0;
        $totalWorkHour = $workHour;
        $lateHour =0;
        $earlyHour =0;
        $absentCount = null;
        if ($this->time_in && $this->time_out && $this->time_in != "00:00:00" && $this->time_out != "00:00:00")
        {
            $startDate = $this->date_in;
            $endDate = $this->date_out;

            $shift = $this->workScheduleAssignment->shift;
            $shiftStart = "$startDate $shift->start";
            $shiftEnd = "$endDate $shift->end";

            $shiftStartDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $shiftStart);
            $shiftStartDateTimeAddFive = $shiftStartDateTime->addMinutes(5);

            $shiftEndDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $shiftEnd);
            $shiftEndDateTimeSubFive = $shiftEndDateTime->subMinutes(5);

            $dateTimeStart = "$startDate $this->time_in";
            $dateTimeEnd = "$endDate $this->time_out";

            $dateTimeStart = Carbon::createFromFormat('Y-m-d H:i:s', $dateTimeStart);
    
            $dateTimeEnd = Carbon::createFromFormat('Y-m-d H:i:s', $dateTimeEnd);
            
            if ($dateTimeStart->greaterThan($shiftStartDateTimeAddFive)) {
                $lateMinute = $dateTimeStart->diffInMinutes($shiftStartDateTimeAddFive);
            } 
            if ($dateTimeEnd->lessThan($shiftEndDateTimeSubFive)) {
                $earlyMinute = $shiftEndDateTimeSubFive->diffInMinutes($dateTimeEnd);
            }

            $totalWorkMinute = 8 * 60 - $lateMinute - $earlyMinute;
            $totalWorkHour = $this->minutesToHoursAndMinutes($totalWorkMinute);
            $earlyHour = $this->minutesToHoursAndMinutes($earlyMinute);
            $lateHour = $this->minutesToHoursAndMinutes($lateMinute);

        }elseif ($this->time_in == "00:00:00" && $this->time_out == "00:00:00"){
            $absentCount = 1;
        }
        return collect([
            'workHour' => $totalWorkHour !== 0 ? $totalWorkHour : null,
            'leaveCount' => null,
            'absentCount' => $absentCount,
            'lateHour' => $lateHour !== 0 ? $lateHour : null,
            'earlyHour' => $earlyHour !== 0 ? $earlyHour : null,
        ]);
    }
    function minutesToHoursAndMinutes($minutes) {
        $hours = intval($minutes / 60);
        $minutes %= 60;
        return $hours + ($minutes / 100);
    }

}
