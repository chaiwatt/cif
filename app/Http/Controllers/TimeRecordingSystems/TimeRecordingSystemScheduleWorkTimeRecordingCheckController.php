<?php

namespace App\Http\Controllers\TimeRecordingSystems;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Month;
use App\Models\PayDayRange;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use App\Models\WorkScheduleUser;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Models\WorkScheduleMonthNote;
use Illuminate\Support\Facades\Storage;
use App\Models\WorkScheduleAssignmentUser;
use App\Models\WorkScheduleAssignmentUserFile;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\UpdatedRoleGroupCollectionService;

class TimeRecordingSystemScheduleWorkTimeRecordingCheckController extends Controller
{
    private $updatedRoleGroupCollectionService;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
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
        // dd($viewName);

        // ค้นหาปีที่มีการกำหนดงานเรียกงานอย่างน้อยหนึ่งรอบ
        $years = WorkSchedule::distinct()->pluck('year');

        // ค้นหาเดือนทั้งหมด
        $months = Month::all();

        // ค้นหาปีปัจจุบัน
        $currentYear = Carbon::now()->year;

        // ค้นหาเดือนปัจจุบัน
        $currentMonth = Carbon::now()->month;

        // ค้นหา workSchedules ที่มีการกำหนดงานเรียกงานในปีและเดือนปัจจุบัน
        $workSchedules = WorkSchedule::whereHas('assignments', function ($query) use ($currentYear, $currentMonth) {
            $query->where('year', $currentYear)
                ->where('month_id', $currentMonth)
                ->whereNotNull('shift_id');
        })->get();

        // ส่งค่าตัวแปรไปยัง view 'groups.time-recording-system.schedulework.time-recording.index'
        return view($viewName, [
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
    public function search(Request $request)
    {        
        $selectedYear = $request->data['selectedYear'];
        $selectedMonth = $request->data['selectedMonth'];

        $uncheckedIds = WorkScheduleUser::where('user_id', auth()->id())
            ->pluck('work_schedule_id')
            ->toArray();

        $workSchedules = WorkSchedule::whereHas('assignments', function ($query) use ($selectedYear, $selectedMonth) {
            $query->where('year', $selectedYear)
                ->where('month_id', $selectedMonth)
                ->whereNotNull('shift_id');
        })->whereNotIn('id', $uncheckedIds)
        ->get();

        return view('groups.time-recording-system.schedulework.time-recording-check.table-render.work-schedule-table',[
            'workSchedules' => $workSchedules,
            'month' => $selectedMonth,
            'year' => $selectedYear,
            ])->render();
    }

    public function view($workScheduleId,$year,$monthId)
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'show'
        $action = 'show';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];

        // ค้นหาผู้ใช้ตามการกำหนดงานเรียกงานใน workScheduleId, monthId, year
        // $users = $this->getUsersByWorkScheduleAssignment($workScheduleId, $monthId, $year);

        // ค้นหา workSchedule จาก workScheduleId
        $workSchedule = WorkSchedule::find($workScheduleId);

        // ค้นหาเดือนที่ monthId
        $month = Month::find($monthId);
        $payDayRanges = PayDayRange::all();

        // ส่งค่าตัวแปรไปยัง view 'groups.time-recording-system.schedulework.time-recording.import.index'
        return view('groups.time-recording-system.schedulework.time-recording-check.view', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            // 'users' => $users,
            'workSchedule' => $workSchedule,
            'month' => $month,
            'year' => $year,
            'payDayRanges' => $payDayRanges
        ]);
    }

    public function timeRecordCheck(Request $request)
    {
        $startDate = Carbon::createFromFormat('d/m/Y', $request->data['startDate'])->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y', $request->data['endDate'])->format('Y-m-d');
        
        $monthId = $request->data['monthId'];
        $year = $request->data['year'];
        $workScheduleId = $request->data['workScheduleId'];
        $page = optional($request->data)['page'];
        $filter = optional($request->data)['filter'];

        $users = $this->getUsersByWorkScheduleAssignment($startDate, $endDate);
        
        $usersWithWorkScheduleAssignments = [];
        foreach($users as $user)
        {
            // dd($startDate,$endDate);
            $workScheduleAssignmentUsers = $user->getWorkScheduleAssignmentUsersInformation($startDate, $endDate, $year);
            
            $dateInList = $workScheduleAssignmentUsers->pluck('date_in')->toArray();
            
            // Apply filtering based on the selected filter option or show all if filter is not set
            if (!$filter || ($filter == 0) || ($filter == 1 && count($dateInList) == 0) || ($filter == 2 && count($dateInList) > 0)) {
                $usersWithWorkScheduleAssignments[$user->id] = [
                    'user' => $user,
                    'date_in_list' => $dateInList
                ]; 
            }
        }

        $usersCollection = new Collection($usersWithWorkScheduleAssignments);

        // Set up pagination parameters
        $perPage = 20; // Number of items per page
        $currentPage = $request->query('page', $page); // Get the current page from the request query

        // Calculate the items for the current page
        $currentPageItems = $usersCollection->slice(($currentPage - 1) * $perPage, $perPage);

        // Create a LengthAwarePaginator instance for pagination
        $paginatedUsers = new LengthAwarePaginator(
            $currentPageItems,
            $usersCollection->count(),
            $perPage,
            $currentPage,
            ['path' => route('groups.time-recording-system.schedulework.time-recording-check')] // Replace with the correct route name
        );

        return view('groups.time-recording-system.schedulework.time-recording-check.table-render.work-schedule-check-table', [
            'usersWithWorkScheduleAssignments' => $paginatedUsers,
        ])->render();       

    }

    public function viewUser(Request $request)
    {
        $startDate = Carbon::createFromFormat('d/m/Y', $request->data['startDate'])->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y', $request->data['endDate'])->format('Y-m-d');
        $year = $request->data['year'];
        $userId = $request->data['userId'];
        
        $user = User::find($userId);
        $workScheduleAssignmentUsers = $user->getWorkScheduleAssignmentUsersByConditions($startDate,$endDate, $year);
        return view('groups.time-recording-system.schedulework.time-recording-check.table-render.work-schedule-modal-table',[
            'workScheduleAssignmentUsers' => $workScheduleAssignmentUsers
            ])->render();

    }

    public function update(Request $request)
    {
        $timeInValue = $request->data['timeInValue'];
        $timeOutValue = $request->data['timeOutValue'];
        $workScheduleAssignmentUserId = $request->data['workScheduleAssignmentUserId'];
        $page = optional($request->data)['page'];
        $filter = optional($request->data)['filter'];

        if ($timeInValue == null && $timeOutValue == null) {
            $timeInValue = $timeOutValue = '00:00:00';
        }

        WorkScheduleAssignmentUser::find($workScheduleAssignmentUserId)->update([
            'time_in' => $timeInValue,
            'time_out' => $timeOutValue,
            'code' => 'E'
        ]);

        $startDate = Carbon::createFromFormat('d/m/Y', $request->data['startDate'])->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y', $request->data['endDate'])->format('Y-m-d');
        $monthId = $request->data['monthId'];
        $year = $request->data['year'];
        $workScheduleId = $request->data['workScheduleId'];

        $users = $this->getUsersByWorkScheduleAssignment($startDate, $endDate);

        $usersWithWorkScheduleAssignments = [];
        foreach($users as $user)
        {
            $workScheduleAssignmentUsers = $user->getWorkScheduleAssignmentUsersInformation($startDate, $endDate, $year);
            $dateInList = $workScheduleAssignmentUsers->pluck('date_in')->toArray();
            
            // Apply filtering based on the selected filter option or show all if filter is not set
            if (!$filter || ($filter == 0) || ($filter == 1 && count($dateInList) == 0) || ($filter == 2 && count($dateInList) > 0)) {
                $usersWithWorkScheduleAssignments[$user->id] = [
                    'user' => $user,
                    'date_in_list' => $dateInList
                ]; 
            }
        }

        $usersCollection = new Collection($usersWithWorkScheduleAssignments);

        // Set up pagination parameters
        $perPage = 20; // Number of items per page
        $currentPage = $request->query('page', $page); // Get the current page from the request query

        // Calculate the items for the current page
        $currentPageItems = $usersCollection->slice(($currentPage - 1) * $perPage, $perPage);

        // Create a LengthAwarePaginator instance for pagination
        $paginatedUsers = new LengthAwarePaginator(
            $currentPageItems,
            $usersCollection->count(),
            $perPage,
            $currentPage,
            ['path' => route('groups.time-recording-system.schedulework.time-recording-check')] // Replace with the correct route name
        );

        return view('groups.time-recording-system.schedulework.time-recording-check.table-render.work-schedule-check-table', [
            'usersWithWorkScheduleAssignments' => $paginatedUsers,
        ])->render();  
    }

    public function saveNote(Request $request){
        $note = $request->data['note'];
        $monthId = $request->data['monthId'];
        $workScheduleId = $request->data['workScheduleId'];
        $year = $request->data['year'];

        WorkScheduleMonthNote::updateOrCreate(
            [
                'work_schedule_id' => $workScheduleId,
                'month_id' => $monthId,
                'year' => $year,
            ],
            [
                'note' => $note
            ]
        );
    }

    public function getUsersByWorkScheduleAssignment($startDate,$endDate)
    {
        // Convert the start and end date to the correct format
        $startDate = date('Y-m-d', strtotime($startDate));
        $endDate = date('Y-m-d', strtotime($endDate));

        // ค้นหาผู้ใช้ที่มีการกำหนดงานเรียกงานใน workScheduleId และ date_in อยู่ในช่วง startDate ถึง endDate
        $users = User::whereHas('workScheduleAssignmentUsers', function ($query) use ($startDate, $endDate) {
            $query->whereNotNull('date_in')
                ->whereBetween('date_in', [$startDate, $endDate]);
        })->get();

        return $users;

    }

    public function getImage(Request $request)
    {
        $workScheduleAssignmentId = $request->data['workScheduleAssignmentId'];
        $workScheduleAssignment = WorkScheduleAssignmentUserFile::where('work_schedule_assignment_user_id', $workScheduleAssignmentId)
                            ->latest()
                            ->first();
        return response()->json($workScheduleAssignment);
    }
    public function uploadImage(Request $request){
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $workScheduleAssignmentId = $request->input('workScheduleAssignmentId');

            // Store the file in the 'attachments' disk
            $filePath = $file->store('', 'attachments');
            

            // Create a record in the work_schedule_assignment_user_files table
            WorkScheduleAssignmentUserFile::create([
                'work_schedule_assignment_user_id' => $workScheduleAssignmentId,
                'file' => $filePath,
            ]);

            $workScheduleAssignment = WorkScheduleAssignmentUserFile::where('work_schedule_assignment_user_id', $workScheduleAssignmentId)
                                    ->latest()
                                    ->first();
            return response()->json($workScheduleAssignment);
        }
        
    }
    public function deleteImage(Request $request)
    {
        $workScheduleAssignmentUserFileId = $request->data['workScheduleAssignmentUserFileId'];
    
        // Find the file record by its ID
        $workScheduleAssignmentUserFile = WorkScheduleAssignmentUserFile::find($workScheduleAssignmentUserFileId);
        
        if ($workScheduleAssignmentUserFile) {
            // Delete the file from storage
            Storage::disk('attachments')->delete($workScheduleAssignmentUserFile->file);
            
            // Delete the record from the database
            $workScheduleAssignmentUserFile->delete();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'File not found.']);
        }

    }

    public function getLeaveAttachment(Request $request)
    {
        $workScheduleAssignmentUserId = $request->data['workScheduleAssignmentUserId'];
        $leaveAttachment = WorkScheduleAssignmentUser::find($workScheduleAssignmentUserId)->getAttachmentForDate();
        // dd($leaveAttachment);
        return response()->json($leaveAttachment);
    }
    
}
