<?php

namespace App\Helpers;

use App\Models\Shift;
use App\Models\ShiftColor;
use App\Models\ShiftAgreement;

class AddDefaultShiftDependency
{
    // สร้างค่าเริ่มต้นของโมเดลอื่น ๆ ที่สัมพันธ์กันกับโมเดล Shift
    public function addDependencies(Shift $shift,ShiftColor $shiftColor)
    {
        $shiftId = $shift->id;
        $shiftName = $shift->name;
        $shiftCode = $shift->code;
        // dd($shiftCode);
   
        Shift::create([
            'name' => $shiftName .'(วันหยุดประจำสัปดาห์)',
            'code' => $shiftCode.'_H',
            'start' => '00:00:00',
            'end' => '00:00:00',
            'record_start' => '00:00:00',
            'record_end' => '00:00:00',
            'break_start' => '00:00:00',
            'break_end' => '00:00:00',
            'common_code' => $shiftCode,
            'color' => $shiftColor->holiday
        ]);
        Shift::create([
            'name' => $shiftName .'(วันหยุดตามนักขัตฤกษ์)',
            'code' => $shiftCode.'_TH',
            'start' => '00:00:00',
            'end' => '00:00:00',
            'record_start' => '00:00:00',
            'record_end' => '00:00:00',
            'break_start' => '00:00:00',
            'break_end' => '00:00:00',
            'common_code' => $shiftCode,
            'color' => $shiftColor->public_holiday
        ]);
        ShiftAgreement::create([
            'shift_id' => $shiftId,
            'name' => 'ล่วงเวลาก่อนเข้างาน',
            'agreement_id' => 2
        ]);
        ShiftAgreement::create([
            'shift_id' => $shiftId,
            'name' => 'ล่วงเวลาหลังเลิกงาน',
            'agreement_id' => 2
        ]);
        ShiftAgreement::create([
            'shift_id' => $shiftId,
            'name' => 'ค่ากะ',
            'agreement_id' => 6
        ]);
        ShiftAgreement::create([
            'shift_id' => $shiftId,
            'name' => 'ค่าอาหาร',
            'agreement_id' => 7
        ]);
        ShiftAgreement::create([
            'shift_id' => $shiftId,
            'name' => 'ค่าอาหารโอที',
            'agreement_id' => 8
        ]);
        ShiftAgreement::create([
            'shift_id' => $shiftId,
            'name' => 'ไม่บันทึกเวลาเข้างาน',
            'agreement_id' => 14
        ]);
        ShiftAgreement::create([
            'shift_id' => $shiftId,
            'name' => 'ไม่บันทึกเวลาเลิกงาน',
            'agreement_id' => 15
        ]);
        ShiftAgreement::create([
            'shift_id' => $shiftId,
            'name' => 'ขาดงาน',
            'agreement_id' => 11
        ]);
        ShiftAgreement::create([
            'shift_id' => $shiftId,
            'name' => 'มาสาย',
            'agreement_id' => 12
        ]);
        ShiftAgreement::create([
            'shift_id' => $shiftId,
            'name' => 'กลับก่อน',
            'agreement_id' => 13
        ]);
    }
}

