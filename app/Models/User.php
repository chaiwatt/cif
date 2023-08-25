<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\Group;
use App\Models\Leave;
use App\Models\Gender;
use App\Models\Payday;
use App\Models\Prefix;
use App\Models\Approver;
use App\Models\Training;
use App\Models\Education;
use App\Models\Ethnicity;
use App\Models\UserGroup;
use App\Models\Punishment;
use App\Models\LeaveDetail;
use App\Models\Nationality;
use App\Models\EmployeeType;
use App\Models\SalaryRecord;
use App\Models\UserPosition;
use App\Models\WorkSchedule;
use App\Models\UserAttachment;
use App\Models\PositionHistory;
use App\Models\ApproveAuthority;
use App\Models\IncomeDeductUser;
use App\Models\CompanyDepartment;
use Laravel\Sanctum\HasApiTokens;
use App\Models\DiligenceAllowance;
use App\Models\WorkScheduleAssignment;
use Illuminate\Notifications\Notifiable;
use App\Models\WorkScheduleAssignmentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'prefix_id',
        'nationality_id',
        'ethnicity_id',
        'user_position_id',
        'employee_type_id',
        'company_department_id',
        'employee_no',
        'name',
        'lastname',
        'address',
        'phone',
        'hid',
        'passport',
        'start_work_date',
        'birth_date',
        'visa_expiry_date',
        'permit_expiry_date',
        'email',
        'password',
        'tax',
        // 'education_level',
        'time_record_require',
        'bank',
        'bank_account',
        'is_admin',
        'work_permit'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * ตรวจสอบว่าผู้ใช้งานเป็นผู้ดูแลระบบหรือไม่
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->is_admin === '1';
    }

    /**
     * ความสัมพันธ์กับโมเดล WorkSchedule (กำหนดตารางงาน)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function work_schedule()
    {
        return $this->belongsTo(WorkSchedule::class);
    }

    /**
     * ความสัมพันธ์กับโมเดล Gender (เพศ)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    /**
     * ความสัมพันธ์กับโมเดล Prefix (คำนำหน้าชื่อ)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prefix()
    {
        return $this->belongsTo(Prefix::class);
    }

    /**
     * ความสัมพันธ์กับโมเดล Nationality (สัญชาติ)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    /**
     * ความสัมพันธ์กับโมเดล Ethnicity (เชื้อชาติ)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ethnicity()
    {
        return $this->belongsTo(Ethnicity::class);
    }

    /**
     * ความสัมพันธ์กับโมเดล EmployeeType (ประเภทพนักงาน)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee_type()
    {
        return $this->belongsTo(EmployeeType::class);
    }

    /**
     * ความสัมพันธ์กับโมเดล UserPosition (ตำแหน่งงานผู้ใช้งาน)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_position()
    {
        return $this->belongsTo(UserPosition::class);
    }

    /**
     * ความสัมพันธ์กับโมเดล CompanyDepartment (แผนกของบริษัท)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company_department()
    {
        return $this->belongsTo(CompanyDepartment::class);
    }

    /**
     * ความสัมพันธ์กับโมเดล WorkScheduleAssignment (การมอบหมายตารางงาน)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function workScheduleAssignments()
    {
        return $this->belongsToMany(WorkScheduleAssignment::class, 'work_schedule_assignment_users')
            ->withPivot('user_id', 'work_schedule_assignment_id')
            ->withTimestamps();
    }

    /**
     * ความสัมพันธ์กับโมเดล Role (บทบาทผู้ใช้งาน)
     * ผ่านตารางกลาง role_users (บทบาทของผู้ใช้งาน)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_users', 'user_id', 'role_id')
            ->where('role_users.user_id', $this->id);
    }

    /**
     * ความสัมพันธ์กับโมเดล Group (กลุ่ม)
     * ผ่านตารางกลาง group_roles (บทบาทของกลุ่ม)
     * เฉพาะกลุ่มที่มีบทบาทที่ผู้ใช้งานมีอยู่
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_roles', 'role_id', 'group_id')
            ->whereIn('role_id', $this->roles()->pluck('id'));
    }

    /**
     * แปลงค่าวันเกิดเป็นรูปแบบ 'm/d/Y'
     *
     * @param  mixed  $value
     * @return string|null
     */
    public function getBirthDateAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format('m/d/Y');
        }
        return null;
    }

    /**
     * แปลงค่าวันเริ่มงานเป็นรูปแบบ 'm/d/Y'
     *
     * @param  mixed  $value
     * @return string|null
     */
    public function getStartWorkDateAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format('m/d/Y');
        }
        return null;
    }

    /**
     * แปลงค่าวันหมดอายุวีซ่าเป็นรูปแบบ 'm/d/Y'
     *
     * @param  mixed  $value
     * @return string|null
     */
    public function getVisaExpiryDateAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format('m/d/Y');
        }
        return null;
    }

    /**
     * แปลงค่าวันหมดอายุใบอนุญาตเป็นรูปแบบ 'm/d/Y'
     *
     * @param  mixed  $value
     * @return string|null
     */
    public function getPermitExpiryDateAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format('m/d/Y');
        }
        return null;
    }

    /**
     * ความสัมพันธ์กับโมเดล Approver (ผู้อนุมัติ)
     * ผ่านตารางกลาง approver_users (ผู้ใช้งานที่มีสิทธิ์ในสายอนุมัติ)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function approvers()
    {
        return $this->belongsToMany(Approver::class, 'approver_users', 'user_id', 'approver_id');
    }

    public function approveAuthorities()
    {
        return $this->belongsToMany(ApproveAuthority::class, 'approve_authorities', 'user_id', 'approver_id');
    }

    /**
     * ความสัมพันธ์กับโมเดล WorkScheduleAssignmentUser (ผู้ใช้งานที่ได้รับการกำหนดตารางเวลางาน)
     * ผ่านการเชื่อมโยงกับโมเดล WorkScheduleAssignmentUser (ผู้ใช้งานที่ได้รับการกำหนดตารางเวลางาน)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workScheduleAssignmentUsers()
    {
        return $this->hasMany(WorkScheduleAssignmentUser::class);
    }

    public function getWorkScheduleUserByMonthYear($month, $year)
    {
        $workScheduleUser = $this->workScheduleAssignmentUsers()
            ->whereHas('workScheduleAssignment', function ($query) use ($month, $year) {
                $query->where('month_id', $month)
                    ->where('year', $year);
            })
            ->get();

        return $workScheduleUser;
    }

    public function getWorkScheduleAssignmentUserByConditions($day, $month, $year)
    {
        $workScheduleAssignmentUser = $this->workScheduleAssignmentUsers()
            ->whereHas('workScheduleAssignment', function ($query) use ($day, $month, $year) {
                $query->where('day', $day)
                    ->where('month_id', $month)
                    ->where('year', $year);
            })
            ->get();

        return $workScheduleAssignmentUser;
    }

    public function getWorkScheduleAssignmentUsersByConditions($startDate, $endDate, $year)
    {
        $startDate = date('Y-m-d', strtotime($startDate));
        $endDate = date('Y-m-d', strtotime($endDate));
        $workScheduleAssignmentUsers = $this->workScheduleAssignmentUsers()
            // ->whereHas('workScheduleAssignment', function ($query) use ($month, $year) {
            ->whereHas('workScheduleAssignment', function ($query) use ($year) {
                // $query->where('month_id', $month)
                $query->where('year', $year);
            })
            ->whereBetween('date_in', [$startDate, $endDate])
            ->orderBy('date_in') 
            ->get();

        return $workScheduleAssignmentUsers;
    }

    public function getWorkScheduleAssignmentUsersInformation($startDate, $endDate, $year)
    {
        $startDate = date('Y-m-d', strtotime($startDate));
        $endDate = date('Y-m-d', strtotime($endDate));
        
        $workScheduleAssignmentUsers = $this->workScheduleAssignmentUsers()
            ->whereHas('workScheduleAssignment', function ($query) use ($year) {
                $query->where('year', $year)
                    ->whereHas('shift', function ($subQuery) {
                        $subQuery->where('code', 'NOT LIKE', '%_H')
                                ->where('code', 'NOT LIKE', '%_TH');
                    });
            })
            ->whereBetween('date_in', [$startDate, $endDate])
            ->where(function ($query) {
                $query->whereNull('time_in')
                    ->orWhereNull('time_out');
            })
            ->whereDoesntHave('user.leaves', function ($subQuery) {
                $subQuery->where('status', 1)
                ->orWhere('status', 2);
            })
            ->orderBy('date_in')
            ->get();

        return $workScheduleAssignmentUsers;
    }

    public function getHolidayDates($startDate, $endDate)
    {
        $startDate = date('Y-m-d', strtotime($startDate));
        $endDate = date('Y-m-d', strtotime($endDate));
        $holidayDates = $this->workScheduleAssignmentUsers()
            ->whereHas('workScheduleAssignment', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('short_date', [$startDate, $endDate])
                    ->whereHas('shift', function ($subQuery) {
                        $subQuery->where('code', 'LIKE', '%_H')
                                ->orWhere('code', 'LIKE', '%_TH');
                    });
            })
            ->get()
            ->pluck('workScheduleAssignment.short_date');
        return $holidayDates;
    }

    public function getWorkScheduleByCurrentMonth()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $workSchedule = $this->workScheduleAssignmentUsers()
            ->whereHas('workScheduleAssignment', function ($query) use ($currentMonth, $currentYear) {
                $query->where('month_id', $currentMonth)
                    ->where('year', $currentYear);
            })
            ->orderBy('date_in')
            ->with('workScheduleAssignment.workSchedule')
            ->get()
            ->pluck('workScheduleAssignment.workSchedule')
            ->unique('work_schedule_id')
            ->first();

        return $workSchedule;
    }

    public function isShiftAssignment($date)
    {
        $shiftId = $this->workScheduleAssignmentUsers()
            ->whereHas('workScheduleAssignment', function ($query) use ($date) {
                $query->where('short_date', $date);
            })
            ->get()
            ->pluck('workScheduleAssignment.shift_id');
        return $shiftId;
    }

    public function getWorkScheduleAssignmentUsers($startDate, $endDate)
    {
        $startDate = date('Y-m-d', strtotime($startDate));
        $endDate = date('Y-m-d', strtotime($endDate));

        $workScheduleAssignmentUsers = $this->workScheduleAssignmentUsers()
            ->whereBetween('date_in', [$startDate, $endDate])
            ->orderBy('date_in') 
            ->get();

        return $workScheduleAssignmentUsers;
    }


    public function detachWorkScheduleAssignments($workScheduleId, $month, $year)
    {
        $detachIds = $this->workScheduleAssignments()
            // ->where('work_schedule_id', $workScheduleId)
            ->where('month_id', $month)
            ->where('year', $year)
            ->pluck('work_schedule_assignments.id')
            ->toArray();

        $this->workScheduleAssignments()->detach($detachIds);
    }

    public function attachWorkScheduleAssignments($workScheduleAssignments)
    {
        $this->workScheduleAssignments()->attach($workScheduleAssignments);
    }

    public function workSchedules()
    {
        return $this->belongsToMany(WorkSchedule::class, 'work_schedule_users');
    }

    public function userGroups()
    {
        return $this->belongsToMany(UserGroup::class, 'user_group_users', 'user_id', 'user_group_id');
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function leaveDetails()
    {
        return $this->hasManyThrough(LeaveDetail::class, Leave::class, 'user_id', 'leave_id', 'user_id', 'id');
    }
    public function overTimeDetails()
    {
        return $this->hasMany(OverTimeDetail::class);
    }

    public function paydays()
    {
        return $this->belongsToMany(Payday::class, 'user_paydays', 'user_id', 'payday_id');
    }

    public function salaryRecords()
    {
        return $this->hasMany(SalaryRecord::class);
    }

    public function getAuthorizedUsers($documentType)
    {
        $firstApprover = $this->approvers->where('document_type_id', $documentType)->first();

        if ($firstApprover) {
            return $firstApprover->authorizedUsers;
        } else {
            return collect(); 
        }
    }

    public function positionHistories()
    {
        return $this->hasMany(PositionHistory::class);
    }

    public function trainings()
    {
        return $this->hasMany(Training::class);
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    public function punishments()
    {
        return $this->hasMany(Punishment::class);
    }

    public function user_attachments()
    {
        return $this->hasMany(UserAttachment::class);
    }

    public function diligenceAllowance()
    {
        return $this->belongsTo(DiligenceAllowance::class);
    }

    public function getErrorDate()
    {
        $today = Carbon::today();
        $year = $today->year;
        $paydayDetail = $this->getPaydayDetailWithToday();
        
        if($paydayDetail)
        {
            $startDate = $paydayDetail->start_date;
            $endDate = $paydayDetail->end_date;
            $workScheduleAssignmentUsers = $this->getWorkScheduleAssignmentUsersInformation($startDate, $endDate, $year);
            $dateInList = $workScheduleAssignmentUsers->pluck('date_in')->toArray();
            return $dateInList;
        }
        
    }

    public function getPaydayDetailWithToday()
    {       
        $today = Carbon::today();
        $paydayDetail = PaydayDetail::whereDate('end_date', '<=', $today)
            ->whereDate('payment_date', '>=', $today)
            ->whereHas('payday', function ($query) {
                $query->whereHas('users', function ($subQuery) {
                    $subQuery->where('user_id', $this->id);
                });
            })
            ->first();

        return $paydayDetail;
    }

    public function getPaydayWithToday()
    {       
        $today = Carbon::today();
        $paydayWithToday = $this->paydays()->whereHas('paydayDetails', function ($query) use ($today) {
            $query->whereDate('end_date', '<=', $today)
                ->whereDate('payment_date', '>=', $today);
        })->first();
        return $paydayWithToday;
    }

    public function incomeDeductUsers()
    {
        return $this->hasMany(IncomeDeductUser::class, 'user_id');
    }

    public function getIncomeDeductByUsers()
    {
        $paydayDetail = $this->getPaydayDetailWithToday();
        if ($paydayDetail != null)
        {
            $incomeDeductUsers = IncomeDeductUser::where('user_id',$this->id)->where('payday_detail_id',$paydayDetail->id)->get();
            if ($incomeDeductUsers != null)
            {
                return $incomeDeductUsers;
            }else{
                return null;
            }
        }
        return null;
    }

    public function IsvalidTimeInOut($startDate,$endDate)
    {
        $workScheduleAssignmentUsers = WorkScheduleAssignmentUser::where('user_id', $this->id)
            ->where(function ($query) {
                $query->whereNull('time_in')
                    ->orWhereNull('time_out');
            })
            ->where(function ($query) {
                $query->whereNotNull('time_in')
                    ->orWhereNotNull('time_out');
            })
            ->whereBetween('date_in', [$startDate, $endDate])
            ->get();

            return $workScheduleAssignmentUsers;
            
    }

    public function getTimeRecordInfo($startDate,$endDate)
    {
        $result = collect([
            'workHour' => null,
            'leaveCount' => null,
            'absentCount' => null,
            'lateMinute' => null,
            'earlyMinute' => null,
        ]);
        if(count($this->IsvalidTimeInOut($startDate,$endDate)) ==0 ){
            $workScheduleAssignmentUsers = WorkScheduleAssignmentUser::where('user_id', $this->id)
                    ->whereBetween('date_in', [$startDate, $endDate])
                    ->get();

            foreach($workScheduleAssignmentUsers as $workScheduleAssignmentUser)
            {
                $dateTimeIn = $workScheduleAssignmentUser->date_in . ' ' . $workScheduleAssignmentUser->time_in;
                $dateTimeOut = $workScheduleAssignmentUser->date_out . ' ' . $workScheduleAssignmentUser->time_out;
                $shift = $workScheduleAssignmentUser->workScheduleAssignment->shift;
                echo($dateTimeIn . ' ' . $dateTimeOut . ' <br>');
                // echo($shift->start . ' ' . $shift->end . ' <br>');
            }
        }
       
    }
}





 