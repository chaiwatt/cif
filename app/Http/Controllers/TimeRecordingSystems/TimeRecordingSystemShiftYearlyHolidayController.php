<?php

namespace App\Http\Controllers\TimeRecordingSystems;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\YearlyHoliday;
use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\UpdatedRoleGroupCollectionService;

class TimeRecordingSystemShiftYearlyHolidayController extends Controller
{
    private $updatedRoleGroupCollectionService;
    private $activityLogger;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService,ActivityLogger $activityLogger) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
        $this->activityLogger = $activityLogger;
    }
    
    /**
     * แสดงหน้าสำหรับการดูข้อมูล
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

        $currentYear = date('Y');
        $currentYear = date('Y');
        $yearlyHolidays = YearlyHoliday::whereYear('holiday_date', $currentYear)
            ->orderBy('holiday_date')
            ->get();

        $currentYear = Carbon::now()->year;
        $years = YearlyHoliday::distinct()->pluck('year');    

        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'yearlyHolidays' => $yearlyHolidays,
            'permission' => $permission,
            'years' => $years
        ]);
    }

    /**
     * แสดงฟอร์มสร้างรายการใหม่
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $action = 'create';
        $groupUrl = strval(session('groupUrl'));

        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];

        return view('groups.time-recording-system.shift.yearlyholiday.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
        ]);
    }

    /**
     * บันทึกรายการที่สร้างเข้าสู่ฐานข้อมูล
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

        $holiday = $request->holiday;  
        $holidayDate = Carbon::createFromFormat('m/d/Y', $request->HolidayDate)->format('Y-m-d');  
        $yearHoliday = new YearlyHoliday();
        $yearHoliday->name = $holiday; 
        $yearHoliday->holiday_date = $holidayDate; 
        $yearHoliday->day = intval(Carbon::createFromFormat('Y-m-d', $holidayDate)->day);
        $yearHoliday->month = intval(Carbon::createFromFormat('Y-m-d', $holidayDate)->month);
        $yearHoliday->year = intval(Carbon::createFromFormat('Y-m-d', $holidayDate)->year);
        $yearHoliday->save();

        $this->activityLogger->log('เพิ่ม', $yearHoliday);

        return redirect()->route('groups.time-recording-system.shift.yearlyholiday', [
            'message' => 'นำเข้าข้อมูลเรียบร้อยแล้ว'
        ]);
    }

    /**
     * แสดงรายละเอียดของรายการที่เลือก
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

        $yearlyHoliday = YearlyHoliday::findOrFail($id);
        return view('groups.time-recording-system.shift.yearlyholiday.view', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'yearlyHoliday' => $yearlyHoliday
        ]);
    }

    /**
     * อัปเดตรายการที่เลือกในฐานข้อมูล
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

        $holiday = $request->holiday;  
        $holidayDate = Carbon::createFromFormat('m/d/Y', $request->HolidayDate)->format('Y-m-d');  

        $yearHoliday = YearlyHoliday::findOrFail($id);

        $this->activityLogger->log('อัปเดต', $yearHoliday);

        $yearHoliday->update([
            'name' => $holiday,
            'holiday_date' => $holidayDate,
            'day' => intval(Carbon::createFromFormat('Y-m-d', $holidayDate)->day),
            'month' => intval(Carbon::createFromFormat('Y-m-d', $holidayDate)->month),
            'year' => intval(Carbon::createFromFormat('Y-m-d', $holidayDate)->year)
        ]);

        return redirect()->route('groups.time-recording-system.shift.yearlyholiday');
    }

    /**
     * ลบรายการที่เลือกออกจากฐานข้อมูล
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    { 
        $action = 'delete';
        
        $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        
        $yearlyHoliday = YearlyHoliday::findOrFail($id);

        $this->activityLogger->log('ลบ', $yearlyHoliday);
        
        $yearlyHoliday->delete();

        return response()->json(['message' => 'วันหยุดประจำปีได้ถูกลบออกเรียบร้อยแล้ว']);
    }

    public function search(Request $request)
    {
        $action = 'show';
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $permission = $roleGroupCollection['permission'];

        $currentYear = $request->data;
        $yearlyHolidays = YearlyHoliday::where('year', $currentYear)->get();
        return view('groups.time-recording-system.shift.yearlyholiday.table-render.yearlyholiday-table', [
            'yearlyHolidays' => $yearlyHolidays,
            'permission' => $permission
            ])->render();
    }

    /**
     * ตรวจสอบข้อมูลแบบฟอร์ม
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Validation\Validator
     */
    function validateFormData($request)
    {
        $validator = Validator::make($request->all(), [
                'holiday' => 'required',
                'HolidayDate' => 'required|date',
            ]);
        return $validator;
    }

}
