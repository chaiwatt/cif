<?php

namespace App\Http\Controllers\jobs;

use Carbon\Carbon;
use App\Models\Month;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Helpers\AddDefaultWorkScheduleAssignment;
use App\Services\UpdatedRoleGroupCollectionService;

class JobsScheduleWorkScheduleController extends Controller
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
        $groupUrl = session('groupUrl');

        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $viewName = $roleGroupCollection['viewName'];
        $workSchedules = WorkSchedule::all();

        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'workSchedules' => $workSchedules,
        ]);
    }

    public function create()
    {
        $action = 'create';
        $groupUrl = session('groupUrl');

        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $currentYear = Carbon::now()->year;
        $nextYear = $currentYear + 1;
        $years = collect([$currentYear, $nextYear]);
        return view('jobs.schedulework.schedule.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
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
        return redirect()->route('jobs.schedulework.schedule');
    }


    function validateFormData($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        return $validator;
    }
}
