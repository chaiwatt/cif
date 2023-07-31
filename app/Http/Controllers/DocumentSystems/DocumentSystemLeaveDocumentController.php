<?php

namespace App\Http\Controllers\DocumentSystems;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Leave;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Models\CompanyDepartment;
use App\Http\Controllers\Controller;
use App\Models\LeaveDetail;
use App\Models\Month;
use Illuminate\Support\Facades\Validator;
use App\Services\UpdatedRoleGroupCollectionService;

class DocumentSystemLeaveDocumentController extends Controller
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

        // Retrieve Leave records with from_date equal to or greater than today
        // $leaves = Leave::where('from_date', '>=', $currentDate)->get();
        $leaves = Leave::all();
        $months = Month::all();

        $currentYear = Carbon::now()->year;
        $nextYear = $currentYear + 1;
        $years = collect([$currentYear, $nextYear]);

        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'companyDepartments' => $companyDepartments,
            'leaves' => $leaves,
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
        $leaveTypes = LeaveType::all();

        return view('groups.document-system.leave.document.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'users' => $users,
            'leaveTypes' => $leaveTypes
    
        ]);

    }

    public function view($id)
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
        $leaveTypes = LeaveType::all();

        $leave = Leave::find($id);

        return view('groups.document-system.leave.document.view', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'users' => $users,
            'leaveTypes' => $leaveTypes,
            'leave' => $leave
    
        ]);
    }


    public function delete($id)
    {
        $action = 'delete';
        $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);

        $leave = Leave::findOrFail($id);
        $this->activityLogger->log('ลบ', $leave);

        $leave->delete();

        return response()->json(['message' => 'รายการลาได้ถูกลบออกเรียบร้อยแล้ว']);
    }

    public function checkLeave(Request $request)
    {
        $leaveType = LeaveType::find($request->data['leaveType']);
        $userId = $request->data['userId'];
        $haftDayLeave = $request->data['haftDayLeave'] ?? false;
       
        $startDate = Carbon::createFromFormat('d/m/Y', $request->data['startDate'])->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y', $request->data['endDate'])->format('Y-m-d');

        $user = User::find($userId);

        $holidays = $user->getHolidayDates($startDate, $endDate);

        $formattedHolidays = $holidays->map(function ($date) {
            return Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y');
        });

        // Calculate the day count between the start date and end date, including the end date
        $dayCount = Carbon::parse($startDate)->diffInDaysFiltered(function ($date) use ($endDate, $holidays) {
            return !$holidays->contains($date->toDateString());
        }, $endDate) + 1;

        $takeLeaveDates = [];
        $currDate = Carbon::createFromFormat('Y-m-d', $startDate);

        while ($currDate->lte(Carbon::createFromFormat('Y-m-d', $endDate))) {
            if (!$holidays->contains($currDate->format('Y-m-d'))) {
                $takeLeaveDates[] = $currDate->format('d/m/Y');
            }

            $currDate->addDay();
        }

        // Check if it's a half-day leave and subtract 0.5 from the day count
        if ($haftDayLeave) {
            $dayCount -= 0.5;
        }

        return view('groups.document-system.leave.document.modal-render.leave-info-modal',[
            'dayCount' => $dayCount,
            'startDate' => $request->data['startDate'],
            'endDate' => $request->data['endDate'],
            'user' => $user,
            'leaveType' => $leaveType,
            'holidays' => $formattedHolidays,
            'takeLeaveDates' => $takeLeaveDates
            ])->render();

    }

    public function store(Request $request)
    {
        $leaveId = $request->data['leaveId'];
        $leaveType = $request->data['leaveType'];
        $userId = $request->data['userId'];
        $haftDayLeave = $request->data['haftDayLeave'] ?? false;
        $haftDayLeaveType = $request->data['haftDayLeaveType'];
       
        $startDate = Carbon::createFromFormat('d/m/Y', $request->data['startDate'])->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y', $request->data['endDate'])->format('Y-m-d');

        $user = User::find($userId);

        $holidays = $user->getHolidayDates($startDate, $endDate);

        $dayCount = Carbon::parse($startDate)->diffInDaysFiltered(function ($date) use ($endDate, $holidays) {
            return !$holidays->contains($date->toDateString());
        }, $endDate) + 1;

        $takeLeaveDates = [];
        $currDate = Carbon::createFromFormat('Y-m-d', $startDate);

        while ($currDate->lte(Carbon::createFromFormat('Y-m-d', $endDate))) {
            if (!$holidays->contains($currDate->format('Y-m-d'))) {
                $takeLeaveDates[] = $currDate->format('d/m/Y');
            }

            $currDate->addDay();
        }

        if (!isset($leaveId)) {
            $leave = Leave::create([
                'user_id' => $userId,
                'leave_type_id' => $leaveType,
                'from_date' => $startDate,
                'to_date' => $endDate,
                'duration' => $dayCount,
                'half_day' => $request->data['haftDayLeave'],
                'half_day_type' => $haftDayLeaveType,
            ]);

            foreach($takeLeaveDates as $takeLeaveDate)
            {
                $leaveDate = Carbon::createFromFormat('d/m/Y', $takeLeaveDate)->format('Y-m-d');
                LeaveDetail::firstOrCreate([
                    'leave_id' => $leave->id,
                    'from_date' => $leaveDate,
                    'to_date' => $leaveDate
                ]);
            }
        } else {
            LeaveDetail::where('leave_id',$leaveId)->delete();
            $leave = Leave::find($leaveId)->update([
                'user_id' => $userId,
                'leave_type_id' => $leaveType,
                'from_date' => $startDate,
                'to_date' => $endDate,
                'duration' => $dayCount,
                'half_day' => $request->data['haftDayLeave'],
                'half_day_type' => $haftDayLeaveType,
            ]);
            $leave = Leave::find($leaveId);
            foreach($takeLeaveDates as $takeLeaveDate)
            {
                $leaveDate = Carbon::createFromFormat('d/m/Y', $takeLeaveDate)->format('Y-m-d');
                LeaveDetail::firstOrCreate([
                    'leave_id' => $leave->id,
                    'from_date' => $leaveDate,
                    'to_date' => $leaveDate
                ]);
            }
        }
        return;

    }
}
