<?php

namespace App\Http\Controllers\DocumentSystems;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Approver;
use App\Models\OverTime;
use App\Models\SearchField;
use Illuminate\Http\Request;
use App\Models\OverTimeDetail;
use App\Helpers\ActivityLogger;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Services\UpdatedRoleGroupCollectionService;

class DocumentSystemOvertimeApprovalAssignmentController extends Controller
{
    private $updatedRoleGroupCollectionService;
    private $activityLogger;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService,ActivityLogger $activityLogger) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
        $this->activityLogger = $activityLogger;
    }
    public function index($id)
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'show'
        $action = 'show';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];

        $overtime = OverTime::find($id);
        $users = OverTimeDetail::where('over_time_id',$id)->get();

        $users = $overtime->overtimeDetails()->with('user')->get()->pluck('user')->unique();
        $approvers = Approver::all();

        return view('groups.document-system.overtime.document.assignment.index', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'overtime' => $overtime,
            'users' => $users,
            'approvers' => $approvers
        ]);
    }

    public function create($id)
    {

        // กำหนดค่าตัวแปร $action ให้เป็น 'show'
        $action = 'create';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];

        $overtime = OverTime::find($id);

        $users = User::whereDoesntHave('overTimeDetails', function ($query) use ($id) {
            $query->where('over_time_id', $id);
        })->paginate(50);

        return view('groups.document-system.overtime.document.assignment.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'overtime' => $overtime,
            'users' => $users
        ]);
    }
    public function search(Request $request)
    {
        $queryInput = $request->data['searchInput'];
        $overtimeId = $request->data['overtimeId'];

        // dd($queryInput,$overtimeId);
        
        $searchFields = SearchField::where('table', 'users')->where('status', 1)->get();

        $query = User::query();

        foreach ($searchFields as $field) {
            $fieldName = $field['field'];
            $fieldType = $field['type'];

            if ($fieldType === 'foreign') {
                $query->orWhereHas($fieldName, function ($query) use ($fieldName, $queryInput) {
                    $query->where('name', 'like', "%{$queryInput}%");
                });
            } else {
                $query->orWhere($fieldName, 'like', "%{$queryInput}%");
            }
        }

        $userIds = $query->pluck('id');
        $overtimeDetailUserIds = OverTimeDetail::where('over_time_id', $overtimeId)->pluck('user_id');

        $filteredUserIds = $userIds->diff($overtimeDetailUserIds);

        $users = User::whereIn('id', $filteredUserIds)->paginate(50);

        return view('groups.document-system.overtime.document.assignment.table-render.employee-table', ['users' => $users])->render();
    }

    public function store(Request $request)
    {
        if ($request->users === null){
             return redirect()->back()->withErrors('กรุณาเลือกรายการ');
        }
        $selectedUsers = $request->users;
        $overtimeId = $request->overtimeId;
        $overtime = OverTime::find($overtimeId);
        $fromDate = Carbon::createFromFormat('Y-m-d', $overtime->from_date);
        $toDate = Carbon::createFromFormat('Y-m-d', $overtime->to_date)->subDay(); // Subtract one day here
        $startTime = $overtime->start_time;
        $endTime = $overtime->end_time;
        $dateRange = Carbon::parse($fromDate)->daysUntil($toDate->addDay()); // Add the day back for the iteration
        $errorCollection = new Collection();
        foreach ($selectedUsers as $userId) {
            $user = User::find($userId);
            $approvers = $user->approvers->where('document_type_id',2);
            if ($approvers->isNotEmpty()) {
                $authorizedUserIds =$approvers->first()->authorizedUsers->pluck('id')->toArray();
                $approvedList = collect($authorizedUserIds)->map(function ($userId) {
                    return ['user_id' => $userId, 'status' => 0];
                });
                foreach ($dateRange as $date) {
                    $user->overTimeDetails()->create([
                        'over_time_id' => $overtimeId,
                        'from_date' => $date->format('Y-m-d'),
                        'to_date' => $date->format('Y-m-d'),
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'approved_list' => $approvedList->toJson()
                    ]);
                }
            } else {
                $errorCollection->push($user->name . ' ' . $user->lastname); // Add the name and last name to the error collection if no approvers found for the user
            }
        }

        if ($errorCollection->isNotEmpty()) {
            $errorNames = implode(', ', $errorCollection->all());
            return redirect()->back()->withErrors('ไม่พบผู้อนุมัติล่วงเวลา สำหรับ: ' . $errorNames);
        }

        return redirect()->to('groups/document-system/overtime/document/assignment/' . $overtimeId);
    }

    public function importUserGroup(Request $request)
    {
        $overtimeId = $request->overtimeId;
        $approverId = $request->approverId;
        $approver = Approver::findOrFail($approverId);
        $users = $approver->users;

        $overtime = OverTime::find($overtimeId);
        $fromDate = Carbon::createFromFormat('Y-m-d', $overtime->from_date);
        $toDate = Carbon::createFromFormat('Y-m-d', $overtime->to_date)->subDay(); // Subtract one day here
        $startTime = $overtime->start_time;
        $endTime = $overtime->end_time;

        $dateRange = Carbon::parse($fromDate)->daysUntil($toDate->addDay()); // Add the day back for the iteration

        foreach ($users as $user) {
            foreach ($dateRange as $date) {
                $user->overTimeDetails()->create([
                    'over_time_id' => $overtimeId,
                    'from_date' => $date->format('Y-m-d'),
                    'to_date' => $date->format('Y-m-d'),
                    'start_time' => $startTime,
                    'end_time' => $endTime
                ]);
            }
        }
    }
    public function delete($overtimeId,$userId)
    {
        // ค้นหาข้อมูลผู้ใช้จาก userId
        $user = User::find($userId);
        // ถ้าพบข้อมูลผู้ใช้
        if ($user) {
            // ลบการกำหนดงานใน WorkScheduleAssignment ของผู้ใช้ใน workScheduleId, monthId, year
            $user->overTimeDetails()
                ->where('over_time_id', $overtimeId)
                ->delete();
        }

        // กำหนด URL สำหรับ redirect
        $url = "groups/document-system/overtime/document/assignment/{$overtimeId}";

        // ทำการ redirect ไปยัง URL ที่กำหนด
        return redirect()->to($url);

    }

    public function importEmployeeNo(Request $request)
    {
        $employeeNos = $request->data['employeeNos'];
        $overtimeId = $request->data['overtimeId'];

        // dd($employeeNos,$overtimeId);
        // $approver = Approver::findOrFail($approverId);
        $users = User::whereIn('employee_no',$employeeNos)->get();

        $overtime = OverTime::find($overtimeId);
        $fromDate = Carbon::createFromFormat('Y-m-d', $overtime->from_date);
        $toDate = Carbon::createFromFormat('Y-m-d', $overtime->to_date)->subDay(); // Subtract one day here
        $startTime = $overtime->start_time;
        $endTime = $overtime->end_time;

        $dateRange = Carbon::parse($fromDate)->daysUntil($toDate->addDay()); // Add the day back for the iteration

        foreach ($users as $user) {
            foreach ($dateRange as $date) {
                $user->overTimeDetails()->create([
                    'over_time_id' => $overtimeId,
                    'from_date' => $date->format('Y-m-d'),
                    'to_date' => $date->format('Y-m-d'),
                    'start_time' => $startTime,
                    'end_time' => $endTime
                ]);
            }
        }
    }
}
