<?php

namespace App\Http\Controllers\Jobs;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\Group;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Models\RoleGroupJson;
use App\Models\YearlyHoliday;
use App\Http\Controllers\Controller;
use App\Services\AccessGroupService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class JobsShiftYearlyHolidayController extends Controller
{
    private $accessGroupService;

    public function __construct(AccessGroupService $accessGroupService)
    {
        $this->accessGroupService = $accessGroupService;
    }
     public function index()
    {
        $action = 'show';
        $groupUrl = session('groupUrl');
        $roleGroupCollection = $this->getUpdatedRoleGroupCollection($action);
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
        $roleGroupCollection = $this->getUpdatedRoleGroupCollection($action);
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
        $roleGroupCollection = $this->getUpdatedRoleGroupCollection($action);
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
    public function getUpdatedRoleGroupCollection($action)
    {
        $user = auth()->user();

        $filterRoute = $this->filterRoute(Route::currentRouteName());
        $job = Job::where('route',$filterRoute)->first();

        $groupId = $job->group_module_job->group_id;
        $moduleId = $job->group_module_job->module_id;
        $viewName = $job->view;

        $group = Group::findOrFail($groupId);
        $module = Module::findOrFail($moduleId);
            
        $this->accessGroupService->hasAccess($user, $group);
        $updatedRoleGroupCollection = $this->getRoleGroupJson($user,$group);
        $permission = $this->accessGroupService->hasPermission($updatedRoleGroupCollection, $module, $job, $action);
        return [
            'updatedRoleGroupCollection' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'viewName' => $viewName
        ];
    }

    public function delete($id)
    {
        $action = 'delete';
        $this->getUpdatedRoleGroupCollection($action);

        $yearlyHoliday = YearlyHoliday::findOrFail($id);
        $yearlyHoliday->delete();

        return response()->json(['message' => 'วันหยุดประจำปีได้ถูกลบออกเรียบร้อยแล้ว']);
    }
    function filterRoute($route)
    {
        $parts = explode(".", $route);
        return $parts[0] . "." . $parts[1] . "." . $parts[2];
    }
    
    function getRoleGroupJson($user,$group)
    {
        $role = $user->roles->first();
        $roleGroupJson = json_decode(RoleGroupJson::where('role_id',$role->id)->where('group_id',$group->id)->first()->json);
        $roleGroupCollection = collect($roleGroupJson);
        $updatedRoleGroupCollection = $roleGroupCollection
            ->filter(function ($module) {
                return $module->enable === true || $module->enable === "true"; // Compare with boolean true
            })->map(function ($module) {
            $module->jobs = collect($module->jobs)->map(function ($job) {
                $jobModel = Job::find($job->job_id);
                $job->job_view = $jobModel->view;
                $job->job_route = $jobModel->route;
                return $job;
            });
            $moduleModel = Module::find($module->module_id);
            $module->module_icon = $moduleModel->icon;
            return $module;
        }); 
        return  $updatedRoleGroupCollection;
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
