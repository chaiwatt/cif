<?php

namespace App\Http\Controllers\jobs;

use App\Models\Month;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\AddDefaultWorkScheduleAssignment;
use App\Services\UpdatedRoleGroupCollectionService;

class JobsScheduleWorkScheduleAssignmentController extends Controller
{
    private $updatedRoleGroupCollectionService;
    private $addDefaultWorkScheduleAssignment;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService, AddDefaultWorkScheduleAssignment $addDefaultWorkScheduleAssignment) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
        $this->addDefaultWorkScheduleAssignment = $addDefaultWorkScheduleAssignment;
    }
    public function index($id)
    {
        $action = 'update';
        $groupUrl = session('groupUrl');

        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $viewRoute = $roleGroupCollection['viewRoute'];
        $workSchedule = WorkSchedule::findOrFail($id);
        $year = $workSchedule->year;
        $uniqueMonths = $workSchedule->assignments()
            ->where('year', $year)
            ->distinct('month_id')
            ->pluck('month_id');

        $months = Month::whereIn('id', $uniqueMonths)->get();   

        return view('jobs.schedulework.schedule.assignment.index', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'months' => $months,
            'workSchedule' => $workSchedule,
            'viewRoute' => $viewRoute
        ]);
    }
}
