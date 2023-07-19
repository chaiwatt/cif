<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\WorkSchedule;
use App\Models\ShiftAgreement;
use Illuminate\Support\Facades\DB;
use App\Models\WorkScheduleAssignment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shift extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'code',
        'start',
        'end',
        'record_start',
        'record_end',
        'break_start',
        'break_end',
        'duration',
        'break_hour',
        'multiply',
        'common_code',
        'shift_type_id',
        'color'
    ];
    /**
     * ความสัมพันธ์กับโมเดล ShiftAgreement (ข้อตกลงเวลางาน) ผ่านการสร้างความสัมพันธ์แบบ One-to-Many
     * (ข้อตกลงเวลางานที่เกี่ยวข้องกับผู้ใช้งาน)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shiftAgreements()
    {
        return $this->hasMany(ShiftAgreement::class);
    }

    /**
     * เมื่อเรียกใช้งานแอตทริบิวต์ 'record_start' จะทำการแปลงค่าให้เป็นรูปแบบ 'm/d/Y'
     *
     * @param  mixed  $value
     * @return string|null
     */
    public function getRecordStartAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format('m/d/Y');
        }
        return null;
    }

    /**
     * เมื่อเรียกใช้งานแอตทริบิวต์ 'record_end' จะทำการแปลงค่าให้เป็นรูปแบบ 'm/d/Y'
     *
     * @param  mixed  $value
     * @return string|null
     */
    public function getRecordEndAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format('m/d/Y');
        }
        return null;
    }

    /**
     * เมื่อเรียกใช้งานแอตทริบิวต์ 'break_start' จะทำการแปลงค่าให้เป็นรูปแบบ 'm/d/Y'
     *
     * @param  mixed  $value
     * @return string|null
     */
    public function getBreakStartAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format('m/d/Y');
        }
        return null;
    }

    /**
     * เมื่อเรียกใช้งานแอตทริบิวต์ 'break_end' จะทำการแปลงค่าให้เป็นรูปแบบ 'm/d/Y'
     *
     * @param  mixed  $value
     * @return string|null
     */
    public function getBreakEndAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format('m/d/Y');
        }
        return null;
    }

    /**
     * เมื่อเรียกใช้งานแอตทริบิวต์ 'duration' จะทำการแปลงค่าให้เป็นรูปแบบ 'HH.MM' (ชั่วโมง.นาที)
     *
     * @param  mixed  $value
     * @return string
     */
    public function getDurationAttribute($value)
    {
        $hours = floor($value);
        $minutes = ($value - $hours) * 60;

        $formattedHours = str_pad($hours, 2, '0', STR_PAD_LEFT);
        $formattedMinutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);

        return $formattedHours . '.' . $formattedMinutes;
    }

    /**
     * เมื่อเรียกใช้งานแอตทริบิวต์ 'break_hour' จะทำการแปลงค่าให้เป็นรูปแบบ 'H.MM' (ชั่วโมง.นาที)
     *
     * @param  mixed  $value
     * @return string
     */
    public function getBreakHourAttribute($value)
    {
        $hours = floor($value);
        $minutes = ($value - $hours) * 60;

        $formattedHours = (string)$hours;
        $formattedMinutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);

        return $formattedHours . '.' . $formattedMinutes;
    }

    /**
     * เมื่อเรียกใช้งานแอตทริบิวต์ 'multiply' จะทำการแปลงค่าให้เป็นรูปแบบ 'H.MM' (ชั่วโมง.นาที)
     *
     * @param  mixed  $value
     * @return string
     */
    public function getMultiplyAttribute($value)
    {
        $hours = floor($value);
        $minutes = ($value - $hours) * 60;

        $formattedHours = (string)$hours;
        $formattedMinutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);

        return $formattedHours . '.' . $formattedMinutes;
    }

    /**
     * ความสัมพันธ์กับโมเดล WorkScheduleAssignment (การกำหนดตารางเวลางาน)
     * ผ่านการเชื่อมโยงกับโมเดล WorkScheduleAssignment (การกำหนดตารางเวลางาน)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workScheduleAssignments()
    {
        return $this->hasMany(WorkScheduleAssignment::class);
    }

     /**
     * ความสัมพันธ์กับโมเดล WorkSchedule 
     * ผ่านการเชื่อมโยงกับโมเดล WorkSchedule 
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workSchedules()
    {
        return $this->belongsToMany(WorkSchedule::class, 'work_schedule_shifts');
    }

    public function existsInWorkScheduleShifts($workScheduleId)
    {
        return $this->workSchedules()
                    ->where('work_schedule_id', $workScheduleId)
                    ->exists();
    }

    public function getIsShiftHolidayAttribute()
    {
        return $this->start === "00:00:00" && $this->end === "00:00:00";
    }

    public function getShiftTypeAttribute()
    {
        if ($this->shift_type_id == 1) {
            return 'FULL_DAY_SHIFT';
        } elseif ($this->shift_type_id == 2) {
            return 'CROSS_DAY_SHIFT';
        }
        // Default fallback if shift_type_id doesn't match any case
        return null;
    }

}
