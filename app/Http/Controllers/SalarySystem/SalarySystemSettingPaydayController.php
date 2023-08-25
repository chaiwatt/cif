<?php

namespace App\Http\Controllers\SalarySystem;

use Carbon\Carbon;
use App\Models\Payday;
use App\Models\PayDayRange;
use App\Models\EmployeeType;
use App\Models\PaydayDetail;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Helpers\PayDaySameMonthGenerator;
use Illuminate\Support\Facades\Validator;
use App\Helpers\PayDayCrossMonthGenerator;
use App\Helpers\AddDefaultWorkScheduleAssignment;
use App\Services\UpdatedRoleGroupCollectionService;

class SalarySystemSettingPaydayController extends Controller
{
    private $updatedRoleGroupCollectionService;
    private $addDefaultWorkScheduleAssignment;
    private $activityLogger;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService, AddDefaultWorkScheduleAssignment $addDefaultWorkScheduleAssignment,ActivityLogger $activityLogger) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
        $this->addDefaultWorkScheduleAssignment = $addDefaultWorkScheduleAssignment;
        $this->activityLogger = $activityLogger;
    }
    public function index()
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'show'
        $action = 'show';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission, viewName โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $viewName = $roleGroupCollection['viewName'];
        $payDayRanges = Payday::all();
        $currentYear = Carbon::now()->year;
        $paydays = Payday::where('year', $currentYear)->get();

        $years = Payday::distinct()->pluck('year');

        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'payDayRanges' => $payDayRanges,
            'paydays' => $paydays,
            'years' => $years

            
        ]);
    }

    public function create()
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'create'
        $action = 'create';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission, viewName โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        // $employeeTypes = EmployeeType::all();

        $currentYear = Carbon::now()->year;
        $nextYear = $currentYear + 1;
        $years = collect([$currentYear, $nextYear]);

        return view('groups.salary-system.setting.payday.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'years' => $years
        ]);
    }
    public function store(Request $request)
    {
        // ตรวจสอบความถูกต้องของข้อมูลแบบฟอร์ม
        $validator = $this->validateFormData($request);
        if ($validator->fails()) {
            // ในกรณีที่ข้อมูลไม่ถูกต้อง กลับไปยังหน้าก่อนหน้าพร้อมแสดงข้อผิดพลาดและข้อมูลที่กรอก
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ดึงข้อมูลจากแบบฟอร์ม
        $name = $request->name;
        $year = $request->year;
        $crossMonth = $request->crossMonth;
        $paymentType = $request->paymentType;
        $duration = $request->duration;
        $startDay = $request->startDay;
        $endDay = $request->endDay;

        $payday=Payday::create([
            'name' => $name,
            'year' => $year,
            'cross_month' => $crossMonth,
            'start_day' => $startDay,
            'end_day' => $endDay,
            'payment_type' => $paymentType,
            'duration' => $duration,
        ]);

        $this->assignMonth($payday->id,$paymentType,$duration,$crossMonth,$startDay,$endDay,$year);

        return redirect()->route('groups.salary-system.setting.payday', [
            'message' => 'นำเข้าข้อมูลเรียบร้อยแล้ว'
        ]);
    }
    
    public function assignMonth($paydayId,$paymentType,$numDayToPayment,$crossMonth,$startDay,$endDay,$year)
    {
        $startDate = ($year-1) .'-12-'.$startDay;
        $endDate = $year .'-01-'.$endDay;
        if ($crossMonth == 2)
        {
            $startDate = $year .'-01-'.$startDay;
            $endDate = $year .'-01-'.$endDay;
        }

        $useEndMonth = true;
        $numPayDays = 12;
        $payDays = [];
        if ($paymentType === "2") {
            $useEndMonth = false;
        }

        if (Carbon::parse($endDate)->greaterThan(Carbon::parse($startDate)) && Carbon::parse($endDate)->month !== Carbon::parse($startDate)->month) {
            $generator = new PayDayCrossMonthGenerator();
            $payDays = $generator->generateCrossMonthPayDays($startDate, $endDate, $numPayDays, $useEndMonth,$numDayToPayment); // or false based on your use case
        } else {
            
            $generator = new PayDaySameMonthGenerator();
            $payDays = $generator->generateSameMonthPayDays($startDate, $endDate, $numPayDays, $useEndMonth,$numDayToPayment); // or false based on your use case
        }

        foreach ($payDays as $payDay) {
            $existingRecord = PaydayDetail::where('payday_id', $paydayId)
                ->where('month_id', $payDay['month'])
                ->first();
            if ($existingRecord) {
                $existingRecord->update([
                    'start_date' => Carbon::createFromFormat('Y-m-d', $payDay['startDate']),
                    'end_date' => Carbon::createFromFormat('Y-m-d', $payDay['endDate']),
                    'payment_date' => Carbon::createFromFormat('Y-m-d', $payDay['paymentDate']),
                ]);
            } else {
                PaydayDetail::create([
                    'payday_id' => $paydayId,
                    'month_id' => $payDay['month'],
                    'start_date' => Carbon::createFromFormat('Y-m-d', $payDay['startDate']),
                    'end_date' => Carbon::createFromFormat('Y-m-d', $payDay['endDate']),
                    'payment_date' => Carbon::createFromFormat('Y-m-d', $payDay['paymentDate']),
                ]);
            }
        }

    }

    public function view($id)
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'create'
        $action = 'update';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission, viewName โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $payDay = Payday::find($id);
        $currentYear = Carbon::now()->year;
        $nextYear = $currentYear + 1;
        $years = collect([$currentYear, $nextYear]);
        

        return view('groups.salary-system.setting.payday.view', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'payDay' => $payDay,
            'years' => $years
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validateFormData($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ดึงข้อมูลจากแบบฟอร์ม
        $name = $request->name;
        $year = $request->year;
        $crossMonth = $request->crossMonth;
        $paymentType = $request->paymentType;
        $duration = $request->duration;
        $startDay = $request->startDay;
        $endDay = $request->endDay;

        Payday::find($id)->update([
            'name' => $name,
            'year' => $year,
            'cross_month' => $crossMonth,
            'start_day' => $startDay,
            'end_day' => $endDay,
            'payment_type' => $paymentType,
            'duration' => $duration
        ]);

        $payday = PayDay::find($id);

        PaydayDetail::where('payday_id',$id)->whereYear('payment_date',$year)->delete();

        $this->assignMonth($payday->id,$paymentType,$duration,$crossMonth,$startDay,$endDay,$year);

        return redirect()->route('groups.salary-system.setting.payday', [
            'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว'
        ]);

    }

    public function delete($id)
    {
        $payDay = Payday::findOrFail($id);

        $this->activityLogger->log('ลบ', $payDay);

        $payDay->delete();

        return response()->json(['message' => 'รอบคำนวนเงินเดือนได้ถูกลบออกเรียบร้อยแล้ว']);
    }


    public function validateFormData($request)
    {
        // ตรวจสอบความถูกต้องของข้อมูลในฟอร์ม
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'year' => 'required',
            'duration' => 'required|numeric|min:1',
            'startDay' => 'required|numeric|max:31', // Validation rules for startDay
            'endDay' => 'required|numeric|max:31',   // Validation rules for endDay
        ]);

        // ส่งกลับตัว validator
        return $validator;
    }
}
