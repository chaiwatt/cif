<?php

namespace App\Http\Controllers\TimeRecordingSystems;

use App\Models\Shift;
use App\Models\ShiftColor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Helpers\AddDefaultShiftDependency;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts = Shift::all();

        // ส่งข้อมูลกลับหรือส่ง shifts ไปยังวิว
        return response()->json(['shifts' => $shifts]);
    }

    public function view($id)
    {
        // ดึงข้อมูลของ Shift พร้อมกับข้อมูลที่เกี่ยวข้อง
        $shift = Shift::findOrFail($id);
        $shiftAgreements = $shift->shiftAgreements;

        // คืนค่า Shift พร้อมกับข้อมูลที่เกี่ยวข้อง
        return response()->json([
            'shift' => $shift,
            'shiftAgreements' => $shiftAgreements
        ]);

    }
    
    public function store(Request $request)
    {
        // ตรวจสอบความถูกต้องของข้อมูลคำขอ
        $validator = $this->validateShiftData($request);

        // ตรวจสอบว่าการตรวจสอบผิดพลาดหรือไม่
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // ประมวลผลข้อมูลคำขอเพื่อสร้าง Shift ใหม่
        $randomShiftColor = ShiftColor::inRandomOrder()->first();
        $shift = new Shift();
        $shift->name = $request->name;
        $shift->code = $request->code;
        $shift->start = $request->start;
        $shift->end = $request->end;
        $shift->record_start = $request->record_start;
        $shift->record_end = $request->record_end;
        $shift->break_start = $request->break_start;
        $shift->break_end = $request->break_end;
        $shift->color = $randomShiftColor->regular;
        $shift->duration = $request->duration ?? 8;
        $shift->multiply = $request->multiply ?? 1;
        $shift->save();

        // สร้างค่าเริ่มต้นของโมเดลอื่น ๆ ที่สัมพันธ์กันกับโมเดล Shift โดยเรียกใช้คลาส AddDefaultShiftDependency
        $dependencyAdder = new AddDefaultShiftDependency();
        $dependencyAdder->addDependencies($shift,$randomShiftColor);

        // ส่งข้อมูลกลับหรือเปลี่ยนเส้นทางไปยังหน้าสำเร็จ
        return response()->json(['message' => 'สร้าง Shift เรียบร้อยแล้ว']);
    }

    public function update(Request $request, $id)
    {
        // ตรวจสอบความถูกต้องของข้อมูลคำขอ
        $validator = $this->validateShiftData($request);

        // ตรวจสอบว่าการตรวจสอบผิดพลาดหรือไม่
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // ค้นหา Shift ตาม ID
        $shift = Shift::findOrFail($id);

        // อัปเดตคุณสมบัติของ Shift
        $shift->name = $request->input('name');
        $shift->code = $request->input('code');
        $shift->start = $request->input('start');
        $shift->end = $request->input('end');
        $shift->duration = $request->input('duration', 8);
        $shift->multiply = $request->input('multiply', 1);

        // บันทึก Shift ที่อัปเดตแล้ว
        $shift->save();

        // ส่งข้อมูลกลับหรือเปลี่ยนเส้นทางไปยังหน้าสำเร็จ
        return response()->json(['message' => 'อัปเดต Shift เรียบร้อยแล้ว']);
    }

    public function delete(Request $request, $id)
    {
        // ค้นหา Shift ตาม ID
        $shift = Shift::findOrFail($id);

        // ลบ Shift
        $shift->delete();

        // ส่งข้อมูลกลับหรือเปลี่ยนเส้นทางไปยังหน้าสำเร็จ
        return response()->json(['message' => 'ลบ Shift เรียบร้อยแล้ว']);
    }
    
    private function validateShiftData(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string',
            'code' => 'required|string',
            'start' => 'required|date_format:H:i:s',
            'end' => 'required|date_format:H:i:s|after:start',
            'duration' => 'integer|min:1',
            'multiply' => 'integer|min:1',
        ]);
    }
}