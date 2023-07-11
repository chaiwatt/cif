<?php

namespace App\Http\Controllers\TimeRecordingSystems;

use Carbon\Carbon;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Models\WorkScheduleUser;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Helpers\AddDefaultWorkScheduleAssignment;
use App\Services\UpdatedRoleGroupCollectionService;

class TimeRecordingSystemSettingWorkScheduleVisibilityController extends Controller
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

    public function store(Request $request)
    {
        $selectedIds = $request->workSchedules;
        $allIds = WorkSchedule::all()->pluck('id')->toArray();
        $uncheckedIds = array_diff($allIds, $selectedIds);

        $currentUserId = auth()->id();

        // Detach the current user from all work schedules
        WorkSchedule::whereHas('users', function ($query) use ($currentUserId) {
            $query->where('user_id', $currentUserId);
        })->get()->each(function ($workSchedule) use ($currentUserId) {
            $workSchedule->users()->detach($currentUserId);
        });

        // Attach the current user to the unchecked IDs
        $uncheckedWorkSchedules = WorkSchedule::whereIn('id', $uncheckedIds)->get();
        $uncheckedWorkSchedules->each(function ($workSchedule) use ($currentUserId) {
            $workSchedule->users()->attach($currentUserId);
        });

        return redirect()->route('groups.time-recording-system.setting.work-schedule-visibility');
    }
}
