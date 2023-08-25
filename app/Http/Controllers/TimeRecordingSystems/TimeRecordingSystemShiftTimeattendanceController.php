<?php

namespace App\Http\Controllers\TimeRecordingSystems;

use Carbon\Carbon;
use App\Models\Shift;
use App\Models\ShiftType;
use App\Models\ShiftColor;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Helpers\AddDefaultShiftDependency;
use App\Services\UpdatedRoleGroupCollectionService;

class TimeRecordingSystemShiftTimeattendanceController extends Controller
{
    private $updatedRoleGroupCollectionService;
    private $activityLogger;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService,ActivityLogger $activityLogger) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
        $this->activityLogger = $activityLogger;
    }

    /**
     * แสดงหน้าต่างของรายการหลักสูตร
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $action = 'show';
        $groupUrl = strval(session('groupUrl'));

        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $viewName = $roleGroupCollection['viewName'];

        // ดึงข้อมูล Shift ทั้งหมด
        $currentYear = Carbon::now()->year;
        $shifts = Shift::where('year', $currentYear)->get();

        $years = Shift::distinct()->pluck('year');

        // ส่งข้อมูลไปยังหน้าแสดงผล
        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'shifts' => $shifts,
            'permission' => $permission,
            'years' => $years
        ]);
    }

    /**
     * แสดงหน้าต่างสำหรับสร้างหลักสูตรใหม่
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $action = 'create';
        $groupUrl = strval(session('groupUrl'));

        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];

        $currentYear = Carbon::now()->year;
        $nextYear = $currentYear + 1;
        $years = collect([$currentYear, $nextYear]);
        $shiftTypes = ShiftType::all();

        // ส่งข้อมูลไปยังหน้าแสดงผลสร้างหลักสูตรใหม่
        return view('groups.time-recording-system.shift.timeattendance.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'years' => $years,
            'shiftTypes' => $shiftTypes
        ]);
    }

    /**
     * บันทึกข้อมูลกะการทำงานใหม่ลงในฐานข้อมูล
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = $this->validateFormData($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ดึงเวลาปัจจุบัน
        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->format('dmYHis');

        // ดึงข้อมูลจากฟอร์ม
        $shiftname = $request->shift;
        $description = $request->description;
        $year = $request->year;
        $code = $formattedDateTime;
        $timepicker_start = $request->timepicker_start;
        $timepicker_end = $request->timepicker_end;
        $record_start_hour = $request->record_start_hour;
        $record_end_hour = $request->record_end_hour;
        $timepicker_break_start = $request->timepicker_break_start;
        $timepicker_break_end = $request->timepicker_break_end;
        $duration = $request->duration;
        $break_hour = $request->break_hour;
        $multiply = $request->multiply;
        $shiftTypeId = $request->shiftType;

        // สร้างและบันทึกข้อมูล Shift ใหม่
        $randomShiftColor = ShiftColor::inRandomOrder()->first();
        $shift = new Shift();
        $shift->name = $shiftname;
        $shift->description = $description;
        $shift->code = $code;
        $shift->year = $year;
        $shift->start = $timepicker_start;
        $shift->end = $timepicker_end;
        $shift->record_start = $record_start_hour;
        $shift->record_end = $record_end_hour;
        $shift->break_start = $timepicker_break_start;
        $shift->break_end = $timepicker_break_end;
        $shift->duration = $duration;
        $shift->break_hour = $break_hour;
        $shift->multiply = $multiply;
        $shift->base_shift = 1;
        $shift->common_code = $code;
        $shift->shift_type_id = $shiftTypeId;
        $shift->color = $randomShiftColor->regular;
        $shift->save();

        $this->activityLogger->log('เพิ่ม', $shift);

        // เพิ่มความสัมพันธ์กับข้อมูลอื่นๆ
        $dependencyAdder = new AddDefaultShiftDependency();
        $dependencyAdder->addDependencies($shift,$randomShiftColor);

        return redirect()->route('groups.time-recording-system.shift.timeattendance');
    }

    /**
     * แสดงหน้าต่างรายละเอียดของกะการทำงาน
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function view($id)
    {
        $action = 'update';
        $groupUrl = strval(session('groupUrl'));

        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];

        // ดึงข้อมูล Shift ตาม ID ที่ระบุ
        $shift = Shift::findOrFail($id);
        // dd($shift);

        $currentYear = Carbon::now()->year;
        $nextYear = $currentYear + 1;
        $years = collect([$currentYear, $nextYear]);
        $shiftTypes = ShiftType::all();

        return view('groups.time-recording-system.shift.timeattendance.view',[
            'groupUrl' => $groupUrl,
            'shift' => $shift, 
            'modules' => $updatedRoleGroupCollection,
            'years' => $years,
            'shiftTypes' => $shiftTypes
        ]);
    }

    /**
     * อัปเดตข้อมูลกะการทำงานในฐานข้อมูล
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validator = $this->validateFormData($request);
        // dd($request->shiftType);
        if ($validator->fails()) {
            
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ดึงข้อมูลจากฟอร์ม
        $shiftname = $request->shift;
        $description = $request->description;
        $timepicker_start = $request->timepicker_start;
        $timepicker_end = $request->timepicker_end;
        $record_start_hour = $request->record_start_hour;
        $record_end_hour = $request->record_end_hour;
        $timepicker_break_start = $request->timepicker_break_start;
        $timepicker_break_end = $request->timepicker_break_end;
        $duration = $request->duration;
        $break_hour = $request->break_hour;
        $multiply = $request->multiply;
        $shiftTypeId = $request->shiftType;

        // อัปเดตข้อมูล Shift ตาม ID ที่ระบุ
        $shift = Shift::findOrFail($id);

        $this->activityLogger->log('อัปเดต', $shift);

        $shift->update([
            'name' => $shiftname,
            'description' => $description,
            'start' => $timepicker_start,
            'end' => $timepicker_end,
            'record_start' => $record_start_hour,
            'record_end' => $record_end_hour,
            'break_start' => $timepicker_break_start,
            'break_end' => $timepicker_break_end,
            'duration' => $duration,
            'break_hour' => $break_hour,
            'multiply' => $multiply,
            'shift_type_id' => $shiftTypeId
        ]);

        $holiday_shift = Shift::where('code',$shift->code.'_H')->first();
        $holiday_shift->update([
            'name' => $shiftname . '(วันหยุดประจำสัปดาห์)',
            'description' => $description,
            'duration' => $duration,
            'break_hour' => $break_hour,
            'multiply' => $multiply,
            'shift_type_id' => $shiftTypeId
        ]);

        $yearly_holiday_shift = Shift::where('code',$shift->code.'_TH')->first();
        $yearly_holiday_shift->update([
            'name' => $shiftname . '(วันหยุดตามนักขัตฤกษ์)',
            'description' => $description,
            'duration' => $duration,
            'break_hour' => $break_hour,
            'multiply' => $multiply,
            'shift_type_id' => $shiftTypeId
        ]);

        return redirect()->route('groups.time-recording-system.shift.timeattendance');
    }

    /**
     * สร้างการสำเนากะการทำงาน
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function duplicate($id)
    {
        $shift = Shift::findOrFail($id); 

        // สร้างการสำเนาของ Shift
        $duplicateShift = $shift->replicate();

        // ดึงเวลาปัจจุบัน
        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->format('dmYHis');

        // อัปเดตข้อมูลของการสำเนา Shift
        $duplicateShift->code = $formattedDateTime . '_' . $shift->code; 
        $duplicateShift->common_code = $formattedDateTime . '_' . $shift->code;
        $duplicateShift->name = $shift->name . '_สำเนา'; 

        $duplicateShift->save();

        $this->activityLogger->log('สำเนา', $duplicateShift);

        $shiftColor = ShiftColor::where('regular',$shift->color)->first();

        // เพิ่มความสัมพันธ์กับข้อมูลอื่นๆ
        $dependencyAdder = new AddDefaultShiftDependency();
        $dependencyAdder->addDependencies($duplicateShift,$shiftColor);

        return redirect()->route('groups.time-recording-system.shift.timeattendance');
    }

    /**
     * ลบกะการทำงานจากฐานข้อมูล
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $action = 'delete';
        $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);

        // ค้นหาและลบกะการทำงานตาม ID ที่ระบุ
        $shift = Shift::findOrFail($id);
        $this->activityLogger->log('ลบ', $shift);
        Shift::where('common_code',$shift->common_code)->delete();

        return response()->json(['message' => 'กะการทำงานได้ถูกลบออกเรียบร้อยแล้ว']);
    }

    public function search(Request $request)
    {
        $action = 'show';
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $permission = $roleGroupCollection['permission'];

        $currentYear = $request->data;
        $shifts = Shift::where('year', $currentYear)->get();
        return view('groups.time-recording-system.shift.timeattendance.table-render.timeattendance-table', [
            'shifts' => $shifts,
            'permission' => $permission
            ])->render();
    }

    function validateFormData($request)
    {
        $validator = Validator::make($request->all(), [
            'shift' => 'required',
            'description' => 'nullable',
            'timepicker_start' => 'required|date_format:H:i',
            'timepicker_end' => 'required|date_format:H:i',
            'record_start_hour' => 'required|regex:/^\d{1,2}\.\d{1}$/',
            'record_end_hour' => 'required|regex:/^\d{1,2}\.\d{1}$/',
            'timepicker_break_start' => 'required|date_format:H:i',
            'timepicker_break_end' => 'required|date_format:H:i',
            'duration' => 'required|regex:/^\d{1,2}\.\d{1}$/',
            'break_hour' => 'required|regex:/^\d{1,2}\.\d{1}$/',
            'multiply' => 'required|regex:/^\d{1,2}\.\d{1}$/',
            'shiftType' => [
                'required',
                Rule::exists(ShiftType::class, 'id')
            ],
        ]);
        return $validator;
    }
}