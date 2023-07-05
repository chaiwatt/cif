<?php

namespace App\Http\Controllers\TimeRecordingSystems;

use Carbon\Carbon;
use App\Models\Month;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Helpers\AddDefaultWorkScheduleAssignment;
use App\Services\UpdatedRoleGroupCollectionService;

class TimeRecordingSystemScheduleWorkScheduleController extends Controller
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
        $action = 'show';
        $groupUrl = strval(session('groupUrl'));

        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $viewName = $roleGroupCollection['viewName'];
        $currentYear = Carbon::now()->year;
        $workSchedules = WorkSchedule::where('year', $currentYear)->get();
        $years = WorkSchedule::distinct()->pluck('year');

        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'workSchedules' => $workSchedules,
            'years' => $years,
        ]);
    }

    public function create()
    {
        $action = 'create';
        $groupUrl = strval(session('groupUrl'));

        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $currentYear = Carbon::now()->year;
        $nextYear = $currentYear + 1;
        $years = collect([$currentYear, $nextYear]);
        return view('groups.time-recording-system.schedulework.schedule.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'years' => $years
        ]);
    }

    public function store(Request $request)
    {
        $validator = $this->validateFormData($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
       
        $workSchedule = new WorkSchedule();
        $workSchedule->name = $request->name;
        $workSchedule->description = $request->description;
        $workSchedule->year = $request->year;
        $workSchedule->save();

        $this->activityLogger->log('เพิ่ม', $workSchedule);
                
        $this->addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule,$request->year);
        return redirect()->route('groups.time-recording-system.schedulework.schedule');
    }

    public function view($id)
    {
        $action = 'update';
        $groupUrl = strval(session('groupUrl'));

        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];

        $workSchedule = WorkSchedule::findOrFail($id);

        $currentYear = Carbon::now()->year;
        $nextYear = $currentYear + 1;
        $years = collect([$currentYear, $nextYear]);

        return view('groups.time-recording-system.schedulework.schedule.view',[
            'groupUrl' => $groupUrl,
            'workSchedule' => $workSchedule, 
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'years' => $years
        ]);
    }
    public function update(Request $request, $id)
    {
        $validator = $this->validateFormData($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $name = $request->name;
        $description = $request->description ?? null;
        $year = $request->year;

        $workSchedule = WorkSchedule::findOrFail($id);

        $this->activityLogger->log('อัปเดต', $workSchedule);

        $workSchedule->update([
            'name' => $name,
            'description' => $description,
            'year' => $year
        ]);
        return redirect()->route('groups.time-recording-system.schedulework.schedule');

    }
   
    public function delete($id)
    { 
        $action = 'delete';
        
        $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        
        $workSchedule = WorkSchedule::findOrFail($id);

        $this->activityLogger->log('ลบ', $workSchedule);
        
        $workSchedule->delete();

        return response()->json(['message' => 'ตารางทำงานได้ถูกลบออกเรียบร้อยแล้ว']);
    }

    public function search(Request $request)
    {
        $action = 'show';
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $permission = $roleGroupCollection['permission'];

        $currentYear = $request->data;
        $workSchedules = WorkSchedule::where('year', $currentYear)->get();
        return view('groups.time-recording-system.schedulework.schedule.table-render.schedule-table', [
            'workSchedules' => $workSchedules,
            'permission' => $permission
            ])->render();
    }

    function validateFormData($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        return $validator;
    }
}
