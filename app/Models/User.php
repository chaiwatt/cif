<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\Group;
use App\Models\Gender;
use App\Models\Prefix;
use App\Models\Approver;
use App\Models\Ethnicity;
use App\Models\Nationality;
use App\Models\EmployeeType;
use App\Models\UserPosition;
use App\Models\WorkSchedule;
use App\Models\CompanyDepartment;
use Laravel\Sanctum\HasApiTokens;
use App\Models\WorkScheduleAssignment;
use Illuminate\Notifications\Notifiable;
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
        'education_level',
        'education_branch',
        'bank',
        'bank_account',
        'is_admin',
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
     * ผ่านตารางกลาง approver_users (ผู้ใช้งานที่มีสิทธิ์ในการอนุมัติ)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function approvers()
    {
        return $this->belongsToMany(Approver::class, 'approver_users', 'user_id', 'approver_id');
    }

}
