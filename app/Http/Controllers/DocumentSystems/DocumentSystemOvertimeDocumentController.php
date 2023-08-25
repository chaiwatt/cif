<?php

namespace App\Http\Controllers\DocumentSystems;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Month;
use App\Models\OverTime;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Models\CompanyDepartment;
use App\Http\Controllers\Controller;
use App\Services\UpdatedRoleGroupCollectionService;
use Illuminate\Support\Facades\Validator;

class DocumentSystemOvertimeDocumentController extends Controller
{
    private $updatedRoleGroupCollectionService;
    private $activityLogger;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService,ActivityLogger $activityLogger) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
        $this->activityLogger = $activityLogger;
    }
    public function index()
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'show'
        $action = 'show';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $viewName = $roleGroupCollection['viewName'];
        $companyDepartments = CompanyDepartment::all();
        
        // Get the current date
        $currentDate = Carbon::today()->format('Y-m-d');

        // Retrieve OverTime records with from_date equal to or greater than today
        // $overtimes = OverTime::where('from_date', '>=', $currentDate)->get();
        $overtimes = OverTime::all();
        $months = Month::all();

        $currentYear = Carbon::now()->year;
        $nextYear = $currentYear + 1;
        $years = collect([$currentYear, $nextYear]);

        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'companyDepartments' => $companyDepartments,
            'overtimes' => $overtimes,
            'months' => $months,
            'years' => $years
        ]);
    }
    public function create()
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'create'
        $action = 'create';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $users = User::all();

        return view('groups.document-system.overtime.document.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'users' => $users,
    
        ]);
    }

    public function store(Request $request)
    {
        $validator = $this->validateFormData($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $startDateTime = $request->startDate;
        $endDateTime = $request->endDate;

        // Parse the startDate using Carbon
        $carbonStartDate = Carbon::createFromFormat('d/m/Y H:i', $startDateTime);
        $startDate = $carbonStartDate->format('Y-m-d');
        $time_start = $carbonStartDate->format('H:i');

        $carbonEndDate = Carbon::createFromFormat('d/m/Y H:i', $endDateTime);
        $endDate = $carbonEndDate->format('Y-m-d');
        $time_end = $carbonEndDate->format('H:i');

        $name = $request->name;

        OverTime::create([
            'name' => $name,
            'from_date' => $startDate,
            'to_date' => $endDate,
            'start_time' => $time_start,
            'end_time' => $time_end
        ]);
        return redirect()->route('groups.document-system.overtime.document');
    }

    public function view($id)
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'update'
        $action = 'update';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $overtime = OverTime::find($id);
        return view('groups.document-system.overtime.document.view', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'overtime' => $overtime
        ]);
    }

    public function update(Request $request,$id)
    {
        $validator = $this->validateFormData($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $startDateTime = $request->startDate;
        $endDateTime = $request->endDate;

        // Parse the startDate using Carbon
        $carbonStartDate = Carbon::createFromFormat('d/m/Y H:i', $startDateTime);
        $startDate = $carbonStartDate->format('Y-m-d');
        $time_start = $carbonStartDate->format('H:i');

        $carbonEndDate = Carbon::createFromFormat('d/m/Y H:i', $endDateTime);
        $endDate = $carbonEndDate->format('Y-m-d');
        $time_end = $carbonEndDate->format('H:i');

        $overtimeId = $id;
        $name = $request->name;
        // $startDate = Carbon::createFromFormat('d/m/Y', $request->startDate)->format('Y-m-d');
        // $endDate = Carbon::createFromFormat('d/m/Y', $request->endDate)->format('Y-m-d');
        // $time_start = $request->timepicker_start;
        // $time_end = $request->timepicker_end;

        // dd($startDate,$time_start,$endDate,$time_end);

        OverTime::find($overtimeId)->update([
            'name' => $name,
            'from_date' => $startDate,
            'to_date' => $endDate,
            'start_time' => $time_start,
            'end_time' => $time_end
        ]);
        return redirect()->route('groups.document-system.overtime.document');
    }

    public function delete($id)
    {
        $overtime = OverTime::findOrFail($id);
        $this->activityLogger->log('ลบ', $overtime);
        $overtime->delete();

        return response()->json(['message' => 'การล่วงเวลาถูกลบออกเรียบร้อยแล้ว']);
    }

    public function validateFormData($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'startDate' => 'required|date_format:d/m/Y H:i',
            'endDate' => 'required|date_format:d/m/Y H:i|after_or_equal:startDate',
        ]);

        return $validator;
    }

}
