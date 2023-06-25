<?php

namespace App\Http\Controllers\Jobs;

use Carbon\Carbon;
use App\Models\Shift;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Helpers\AddDefaultShiftDependency;
use App\Services\UpdatedRoleGroupCollectionService;

class JobsShiftTimeattendanceController extends Controller
{
    private $updatedRoleGroupCollectionService;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
    }

    /**
     * แสดงหน้าต่างของรายการหลักสูตร
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $action = 'show';
        $groupUrl = session('groupUrl');

        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $viewName = $roleGroupCollection['viewName'];

        // ดึงข้อมูล Shift ทั้งหมด
        $shifts = Shift::all();

        // ส่งข้อมูลไปยังหน้าแสดงผล
        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'shifts' => $shifts,
            'permission' => $permission
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
        $groupUrl = session('groupUrl');

        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];

        // ส่งข้อมูลไปยังหน้าแสดงผลสร้างหลักสูตรใหม่
        return view('jobs.shift.timeattendance.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
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
        $code = $formattedDateTime;
        $timepicker_start = $request->timepicker_start;
        $timepicker_end = $request->timepicker_end;
        $timepicker_record_start = $request->timepicker_record_start;
        $timepicker_record_end = $request->timepicker_record_end;
        $timepicker_break_start = $request->timepicker_break_start;
        $timepicker_break_end = $request->timepicker_break_end;
        $duration = $request->duration;
        $break_hour = $request->break_hour;
        $multiply = $request->multiply;

        // สร้างและบันทึกข้อมูล Shift ใหม่
        $shift = new Shift();
        $shift->name = $shiftname;
        $shift->description = $description;
        $shift->code = $code;
        $shift->start = $timepicker_start;
        $shift->end = $timepicker_end;
        $shift->record_start = $timepicker_record_start;
        $shift->record_end = $timepicker_record_end;
        $shift->break_start = $timepicker_break_start;
        $shift->break_end = $timepicker_break_end;
        $shift->duration = $duration;
        $shift->break_hour = $break_hour;
        $shift->multiply = $multiply;
        $shift->base_shift = 1;
        $shift->common_code = $code;
        $shift->save();

        // เพิ่มความสัมพันธ์กับข้อมูลอื่นๆ
        $dependencyAdder = new AddDefaultShiftDependency();
        $dependencyAdder->addDependencies($shift);

        return redirect()->route('jobs.shift.timeattendance');
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
        $groupUrl = session('groupUrl');

        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];

        // ดึงข้อมูล Shift ตาม ID ที่ระบุ
        $shift = Shift::findOrFail($id);

        return view('jobs.shift.timeattendance.view',[
            'groupUrl' => $groupUrl,
            'shift' => $shift, 
            'modules' => $updatedRoleGroupCollection 
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

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ดึงข้อมูลจากฟอร์ม
        $shiftname = $request->shift;
        $description = $request->description;
        $timepicker_start = $request->timepicker_start;
        $timepicker_end = $request->timepicker_end;
        $timepicker_record_start = $request->timepicker_record_start;
        $timepicker_record_end = $request->timepicker_record_end;
        $timepicker_break_start = $request->timepicker_break_start;
        $timepicker_break_end = $request->timepicker_break_end;
        $duration = $request->duration;
        $break_hour = $request->break_hour;
        $multiply = $request->multiply;

        // อัปเดตข้อมูล Shift ตาม ID ที่ระบุ
        $shift = Shift::findOrFail($id);
        $shift->update([
            'name' => $shiftname,
            'description' => $description,
            'start' => $timepicker_start,
            'end' => $timepicker_end,
            'record_start' => $timepicker_record_start,
            'record_end' => $timepicker_record_end,
            'break_start' => $timepicker_break_start,
            'break_end' => $timepicker_break_end,
            'duration' => $duration,
            'break_hour' => $break_hour,
            'multiply' => $multiply,
        ]);

        return redirect()->route('jobs.shift.timeattendance');
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

        // เพิ่มความสัมพันธ์กับข้อมูลอื่นๆ
        $dependencyAdder = new AddDefaultShiftDependency();
        $dependencyAdder->addDependencies($duplicateShift);

        return redirect()->route('jobs.shift.timeattendance');
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
        Shift::where('common_code',$shift->common_code)->delete();

        return response()->json(['message' => 'กะการทำงานได้ถูกลบออกเรียบร้อยแล้ว']);
    }

    function validateFormData($request)
    {
        $validator = Validator::make($request->all(), [
            'shift' => 'required',
            'description' => 'nullable',
            'timepicker_start' => 'required|date_format:H:i',
            'timepicker_end' => 'required|date_format:H:i',
            'timepicker_record_start' => 'required|date_format:H:i',
            'timepicker_record_end' => 'required|date_format:H:i',
            'timepicker_break_start' => 'required|date_format:H:i',
            'timepicker_break_end' => 'required|date_format:H:i',
            'duration' => 'required|regex:/^\d{1,2}\.\d{2}$/',
            'break_hour' => 'required|regex:/^\d{1,2}\.\d{2}$/',
            'multiply' => 'required|regex:/^\d{1,2}\.\d{2}$/',
        ]);
        return $validator;
    }
}
