<?php

namespace App\Http\Controllers\Jobs;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\YearlyHoliday;
use App\Http\Controllers\Controller;
use App\Services\AccessGroupService;
use Illuminate\Support\Facades\Validator;
use App\Services\UpdatedRoleGroupCollectionService;

class JobsShiftYearlyHolidayController extends Controller
{
    private $updatedRoleGroupCollectionService;
    private $accessGroupService;

    public function __construct(
        UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService,
        AccessGroupService $accessGroupService
    ) {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
        $this->accessGroupService = $accessGroupService;
    }
    
     public function index()
    {
        $action = 'show';
        $groupUrl = session('groupUrl');

        $updatedRoleGroupCollectionService = app(UpdatedRoleGroupCollectionService::class);
        $roleGroupCollection = $updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $viewName = $roleGroupCollection['viewName'];

        $currentYear = date('Y');
        $currentYear = date('Y');
        $yearlyHolidays = YearlyHoliday::whereYear('holiday_date', $currentYear)
            ->orderBy('holiday_date')
            ->get();

        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'yearlyHolidays' => $yearlyHolidays,
            'permission' => $permission
        ]);
    }

    public function create()
    {
        $action = 'create';
        $groupUrl = session('groupUrl');

        $updatedRoleGroupCollectionService = app(UpdatedRoleGroupCollectionService::class);
        $roleGroupCollection = $updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];

        return view('jobs.shift.yearlyholiday.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
        ]);
    }

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
        $yearHoliday->save();

        return redirect()->route('jobs.shift.yearlyholiday', [
            'message' => 'นำเข้าข้อมูลเรียบร้อยแล้ว'
        ]);
    }

    public function view($id)
    {
        $action = 'update';
        $groupUrl = session('groupUrl');
        $updatedRoleGroupCollectionService = app(UpdatedRoleGroupCollectionService::class);
        $roleGroupCollection = $updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];

        $yearlyHoliday = YearlyHoliday::findOrFail($id);
        return view('jobs.shift.yearlyholiday.view', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'yearlyHoliday' => $yearlyHoliday
        ]);
    }
public function update(Request $request, $id)
    {
        $validator = $this->validateFormData($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $holiday = $request->holiday;  
        $holidayDate = Carbon::createFromFormat('m/d/Y', $request->HolidayDate)->format('Y-m-d');  

        $yearHoliday = YearlyHoliday::findOrFail($id);
        $yearHoliday->update([
            'name' => $holiday,
            'holiday_date' => $holidayDate
        ]);

        return redirect()->route('jobs.shift.yearlyholiday');
    }

    public function delete($id)
    {
        $action = 'delete';
        $this->getUpdatedRoleGroupCollection($action);

        $updatedRoleGroupCollectionService = app(UpdatedRoleGroupCollectionService::class);
        $roleGroupCollection = $updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);

        $yearlyHoliday = YearlyHoliday::findOrFail($id);
        $yearlyHoliday->delete();

        return response()->json(['message' => 'วันหยุดประจำปีได้ถูกลบออกเรียบร้อยแล้ว']);
    }
    
    function validateFormData($request)
    {
        $validator = Validator::make($request->all(), [
                'holiday' => 'required',
                'HolidayDate' => 'required|date',
            ]);
        return $validator;
    }
}
