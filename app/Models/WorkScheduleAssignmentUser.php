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
        $workHour = 0;
        $lateMinute = 0;
        $earlyMinute = 0;
        $totalWorkHour = $workHour;
        $lateHour =0;
        $earlyHour =0;
        $absentCount = null;
        $holidayShift = $this->isHolidayShift();
        
        if ($this->time_in && $this->time_out && $this->time_in != "00:00:00" && $this->time_out != "00:00:00" && count($holidayShift) == 0)
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
        $totalOvertime = $this->getOvertimeInfo();
        // dd($totalOvertime,$this->user_id);
        return collect([
            'workHour' => $totalWorkHour !== 0 ? $totalWorkHour : null,
            'leaveCount' => $this->getLeaveInfo(),
            'absentCount' => $absentCount,
            'lateHour' => $lateHour !== 0 ? $lateHour : null,
            'earlyHour' => $earlyHour !== 0 ? $earlyHour : null,
            'overTime' => $totalOvertime,
            'earlyMinute' => $earlyMinute !== 0 ? $earlyMinute : null,
            'lateMinute' => $lateMinute !== 0 ? $lateMinute : null,
        ]);
    }
    public function getWorkHourHoliday()
    {
        $userId = $this->user_id;
        $shift = $this->workScheduleAssignment->shift;
        $shiftType = $shift->shift_type_id;
        $scheduleAssignmentDate = ($shiftType == 2) ? $this->date_out : $this->date_in;
        $type = 2;
        $overtimeDetail = OverTimeDetail::where('user_id',$userId)
            ->whereDate('from_date',$scheduleAssignmentDate)
            ->whereHas('overtime', function ($query) use ($type) {
                    $query->where('type', '=', $type);
                })
            ->first();
        if($overtimeDetail == null){
            return 0;
        }    

        $startOvertime = Carbon::parse("$overtimeDetail->from_date $overtimeDetail->start_time");
        $endOverTime = Carbon::parse("$overtimeDetail->to_date $overtimeDetail->end_time");

        $overtimeHourDifference = $startOvertime->diffInHours($endOverTime);
        
        $scheduleAssignmentDateTime = Carbon::parse("$scheduleAssignmentDate $this->time_out")->addMinutes(5);

        if ($scheduleAssignmentDateTime > $startOvertime) {
            $hourDifference = $startOvertime->diffInHours($scheduleAssignmentDateTime);
            if ($hourDifference > $overtimeHourDifference){
                $hourDifference = $overtimeHourDifference;
            }
            if ($hourDifference > 0){
                if ($hourDifference > 4 ){
                    $hourDifference = $hourDifference -1 ;
                }
                return $hourDifference;
            }else{
                
                return 0;
            }
        } else {
            
            return 0;
        }    

    }
    function minutesToHoursAndMinutes($minutes) {
        $hours = intval($minutes / 60);
        $minutes %= 60;
        return $hours + ($minutes / 100);
    }

    function getLeaveInfo()
    {
        $startDate = $this->date_in;
        $endDate = $this->date_out;

        $shift = $this->workScheduleAssignment->shift;
        $shiftStartDate = "$startDate $shift->start";
        $shiftEndDate = "$endDate $shift->end";

        $leaveDetail = LeaveDetail::join('leaves', 'leave_details.leave_id', '=', 'leaves.id')
            ->where('leaves.user_id', $this->user_id)
            ->where(function ($query) use ($shiftStartDate, $shiftEndDate) {
                $query->whereBetween('leave_details.from_date', [$shiftStartDate, $shiftEndDate])
                    ->orWhereBetween('leave_details.to_date', [$shiftStartDate, $shiftEndDate])
                    ->orWhere(function ($subquery) use ($shiftStartDate, $shiftEndDate) {
                        $subquery->where('leave_details.from_date', '<=', $shiftStartDate)
                                ->where('leave_details.to_date', '>=', $shiftEndDate);
                    });
            })
            ->get(['leave_details.*'])->first();
        if($leaveDetail != null){

            $fromDate = Carbon::parse($leaveDetail->from_date);
            $toDate = Carbon::parse($leaveDetail->to_date);
            
            $hourDifference = intval($fromDate->diffInHours($toDate));
            if ( $hourDifference > 4 ){
                $hourDifference = intval($fromDate->diffInHours($toDate))-1;
            }
            $diffInWorkHour = $hourDifference / 8 ;

            return collect([
            'count' => $diffInWorkHour,
            'leaveType' => $leaveDetail->leave->leaveType->id,
            'leaveName' => $leaveDetail->leave->leaveType->name,
            ]);
        }  else{
            return null;
        }  

    }

    // public function isHolidayShift()
    // {      
    //     $workScheduleAssignmentUser = $this->where('user_id',$this->user_id)
    //                 ->whereHas('workScheduleAssignment', function ($query) {
    //                 $query->where('short_date',$this->date_in)
    //                     ->whereHas('shift', function ($subQuery) {
    //                         $subQuery->where('code', 'LIKE', '%_H')
    //                         ->orWhere('code', 'LIKE', '%_TH');
    //                     });
    //             });
    //     $shifId = $workScheduleAssignmentUser->get()->pluck('workScheduleAssignment.shift_id');
    //     return $shifId;
    // }

    public function isHolidayShift()
    {
        $workScheduleAssignmentUser = $this->where('user_id', $this->user_id)
            ->whereHas('workScheduleAssignment.shift', function ($query) {
                $query->where('code', 'LIKE', '%_H')
                    ->orWhere('code', 'LIKE', '%_TH');
            })
            ->with('workScheduleAssignment.shift') // Eager load the 'workScheduleAssignment' and 'shift' relationships
            ->whereHas('workScheduleAssignment', function ($query) {
                $query->where('short_date', $this->date_in);
            });

        $shiftIds = $workScheduleAssignmentUser->get()->pluck('workScheduleAssignment.shift_id');

        return $shiftIds;
    }


    // public function getHolidayWorkScheduleAssignmentUsers()
    // {      
    //     $holidayWorkScheduleAssignmentUsers = $this->where('user_id',$this->user_id)
    //             ->whereHas('workScheduleAssignment', function ($query) {
    //                 $query->where('short_date',$this->date_in)
    //                     ->whereHas('shift', function ($subQuery) {
    //                         $subQuery->where('code', 'LIKE', '%_H')
    //                         ->orWhere('code', 'LIKE', '%_TH');
    //                     });
    //             })->get();
    //     return $holidayWorkScheduleAssignmentUsers;
    // }

    public function getHolidayWorkScheduleAssignmentUsers()
    {
        $holidayWorkScheduleAssignmentUsers = $this->where('user_id', $this->user_id)
            ->whereHas('workScheduleAssignment.shift', function ($query) {
                $query->where('code', 'LIKE', '%_H')
                    ->orWhere('code', 'LIKE', '%_TH');
            })
            ->with('workScheduleAssignment.shift') // Eager load the 'workScheduleAssignment' and 'shift' relationships
            ->whereHas('workScheduleAssignment', function ($query) {
                $query->where('short_date', $this->date_in);
            })
            ->get();

        return $holidayWorkScheduleAssignmentUsers;
    }


    public function getOvertimeInfo()
    {
        // dd($this->date_in);
        $userId = $this->user_id;
        
        $shift = $this->workScheduleAssignment->shift;
        $shiftType = $shift->shift_type_id;
        $scheduleAssignmentDate = ($shiftType == 2) ? $this->date_out : $this->date_in;
        $type = 1;
        $overtimeDetail = OverTimeDetail::where('user_id',$userId)
            ->whereDate('from_date',$scheduleAssignmentDate)
            ->whereHas('overtime', function ($query) use ($type) {
                    $query->where('type', '=', $type);
                })
            ->first();
        
        $holidayShift = $this->isHolidayShift();
        
        if ($overtimeDetail != null && ($this->time_in != null && $this->time_out != null) && count($holidayShift) == 0){
            $startOvertime = Carbon::parse("$overtimeDetail->from_date $overtimeDetail->start_time");
            $endOverTime = Carbon::parse("$overtimeDetail->to_date $overtimeDetail->end_time");
            

            $isHoliday = false;
            $user = User::find($userId);
            $holiday = $user->getHolidayDates($this->date_in, $this->date_out)->toArray();

            if(count($holiday) != 0)
            {
                $isHoliday = true;
            }

            $overtimeHourDifference = $startOvertime->diffInHours($endOverTime);
            
            $scheduleAssignmentDateTime = Carbon::parse("$scheduleAssignmentDate $this->time_out")->addMinutes(5);

            if ($scheduleAssignmentDateTime > $startOvertime) {
                $hourDifference = $startOvertime->diffInHours($scheduleAssignmentDateTime);
                if ($hourDifference > $overtimeHourDifference){
                    $hourDifference = $overtimeHourDifference;
                }
                if ($hourDifference > 0){
                    return collect([
                        'hourDifference' => $hourDifference,
                        'isHoliday' => $isHoliday
                        ]); 
                }else{
                    
                    return null;
                }
            } else {
                
                return null;
            }
        }
        
    }

}
