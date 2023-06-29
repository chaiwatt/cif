<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class YearlyHoliday extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'holiday_date',
        'day',
        'month',
        'year'
    ];
    /**
     * ส่วนประเภทเรียก Attribute สำหรับวันหยุด
     * 
     * @param mixed $value ค่าของ Attribute ที่กำลังเรียกใช้
     * @return string|null ค่าวันหยุดในรูปแบบ 'เดือน/วัน/ปี' หรือค่าว่างถ้าไม่มีค่า
     */
    public function getHolidayDateAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format('m/d/Y');
        }
        return null;
    }
}
