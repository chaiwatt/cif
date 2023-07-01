<?php

namespace App\Http\Controllers\jobs;

use Carbon\Carbon;
use App\Models\Month;
use App\Models\Shift;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use App\Models\WorkScheduleEvent;
use App\Http\Controllers\Controller;
use App\Helpers\AddDefaultWorkScheduleAssignment;
use App\Models\WorkScheduleAssignment;
use App\Models\YearlyHoliday;
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
    public function view($id)
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

        $workSchedule = WorkSchedule::find($id);

        return view('groups.time-recording-system.schedulework.schedule.assignment.index', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'months' => $months,
            'workSchedule' => $workSchedule,
            'viewRoute' => $viewRoute
        ]);
    }
    public function create($scheduleId,$year,$monthId)
    {
        $action = 'create';
        $groupUrl = session('groupUrl');

        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $viewRoute = $roleGroupCollection['viewRoute'];
        $month = Month::find($monthId);
        $workSchedule = WorkSchedule::find($scheduleId);
        $shifts = Shift::all();
        $yearlyHolidays = YearlyHoliday::where('year',$year)->where('month',$month->id)->get();

        $events = WorkScheduleEvent::where('month_id', $month->id)
            ->where('year', $year)
            ->where('work_schedule_id', $scheduleId)
            ->get()
            ->map(function ($event) {
                $shift = Shift::find($event->event_id);
                $mappedEvent = [
                    'id' => $event->event_id,
                    'title' => $event->event_name,
                    'start' => Carbon::parse($event->event_start_date)->format('Y-m-d'),
                    'backgroundColor' => $shift->color,
                    'borderColor' => $shift->color,
                    'allDay' => $event->long_event,
                ];

                if ($event->event_end_date !== null) {
                    $mappedEvent['end'] = Carbon::parse($event->event_end_date)
                                        ->addDay()
                                        ->format('Y-m-d');
                }

                return $mappedEvent;
            });

        return view('groups.time-recording-system.schedulework.schedule.assignment.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'viewRoute' => $viewRoute,
            'month' => $month,
            'workSchedule' => $workSchedule,
            'year' => $year,
            'shifts' => $shifts,
            'events' => $events,
            'yearlyHolidays' => $yearlyHolidays
        ]);
    }
    public function storeCalendar(Request $request)
    {
        $events = $request->data['allEvents'];
        $daySchedules = $request->data['daySchedules'];
        $month = $request->data['month'];
        $year = $request->data['year'];
        $workScheduleId = $request->data['workScheduleId'];

        WorkScheduleEvent::where([
            'work_schedule_id' => $workScheduleId,
            'month_id' => $month,
            'year' => $year
        ])->delete();
        
        foreach($events as $event)
        {
            $workScheduleEvent = new WorkScheduleEvent();
            $workScheduleEvent->work_schedule_id = $workScheduleId;
            $workScheduleEvent->month_id = $month;
            $workScheduleEvent->year = $year;
            $workScheduleEvent->event_id = intval($event['eventId']);
            $workScheduleEvent->event_name = $event['eventName'];
            $workScheduleEvent->event_start_date = $event['eventStartDate'];
            $workScheduleEvent->event_end_date = $event['eventEndDate'] ??  null;
            $workScheduleEvent->long_event = $event['longEvent'];
            $workScheduleEvent->save();
        }
       
        foreach($daySchedules as $daySchedule)
        {
            $eventDate = $daySchedule['eventDate'];
            $shiftId = $daySchedule['eventId'];
            $carbonDate = Carbon::createFromFormat('Y-m-d', $eventDate);
            $day = intval($carbonDate->day);
            $month = intval($carbonDate->month);
            $year = $carbonDate->year;
            WorkScheduleAssignment::where('year',$year)->where('month_id',$month)->where('day',$day)->update([
                'shift_id' => $shiftId
            ]);
        }


        return response()->json(['workScheduleId' => $workScheduleId]);
    }
}
