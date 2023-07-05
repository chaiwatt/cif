<?php

namespace App\Http\Controllers\TimeRecordingSystems;

use Carbon\Carbon;
use App\Models\Month;
use App\Models\WorkSchedule;
use App\Http\Controllers\Controller;
use App\Services\UpdatedRoleGroupCollectionService;

class TimeRecordingSystemScheduleWorkTimeRecordingController extends Controller
{
    private $updatedRoleGroupCollectionService;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
    }
    public function index()
    {
        $action = 'show';
        $groupUrl = strval(session('groupUrl'));
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $years = WorkSchedule::distinct()->pluck('year');
        $months = Month::all();
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $workSchedules = WorkSchedule::whereHas('assignments', function ($query) use ($currentYear, $currentMonth) {
            $query->where('year', $currentYear)
                ->where('month_id', $currentMonth)
                ->whereNotNull('shift_id');
        })->get();

        return view('groups.time-recording-system.schedulework.time-recording.index', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'years' => $years,
            'months' => $months,
            'workSchedules' => $workSchedules,
            'currentYear' => $currentYear,
            'currentMonth' => $currentMonth
        ]);
    }
}
