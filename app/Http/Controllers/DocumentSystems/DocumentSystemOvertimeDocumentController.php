<?php

namespace App\Http\Controllers\DocumentSystems;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Month;
use App\Models\Approver;
use App\Models\OverTime;
use Illuminate\Http\Request;
use App\Models\OverTimeDetail;
use App\Helpers\ActivityLogger;
use App\Models\CompanyDepartment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\UpdatedRoleGroupCollectionService;

class DocumentSystemOvertimeDocumentController extends Controller
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

        // Retrieve OverTime records with from_date equal to or greater than today
        $currentMonth = Carbon::today()->month;
        
        // $overtimes = OverTime::whereMonth('from_date', $currentMonth)->paginate(31);
        $overtimes = OverTime::paginate(31);
        $months = Month::all();

        $currentYear = Carbon::now()->year;
        $nextYear = $currentYear + 1;
        $years = collect([$currentYear, $nextYear]);

        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'companyDepartments' => $companyDepartments,
            'overtimes' => $overtimes,
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
        $approvers = Approver::where('document_type_id',2)->get();
        

        return view('groups.document-system.overtime.document.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'users' => $users,
            'approvers' => $approvers
    
        ]);
    }

    public function store(Request $request)
    {
        
        $validator = $this->validateFormData($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $approver = Approver::find($request->approver);

        $userIds = $approver->authorizedUsers->pluck('id')->toArray();
        $startDateTime = $request->startDate;
        $endDateTime = $request->endDate;
        $type = $request->type;
        $selectedValue = $request->manual_time;

        if ($selectedValue == 1){
            $carbonStartDate = Carbon::createFromFormat('d/m/Y', $startDateTime);
            $startDate = $carbonStartDate->format('Y-m-d');
            $time_start = "00:00";
            $carbonEndDate = Carbon::createFromFormat('d/m/Y', $endDateTime);
            $endDate = $carbonEndDate->format('Y-m-d');
            $time_end = "00:00";
        }else if($selectedValue == 2){
            $carbonStartDate = Carbon::createFromFormat('d/m/Y H:i', $startDateTime);
            $startDate = $carbonStartDate->format('Y-m-d');
            $time_start = $carbonStartDate->format('H:i');

            $carbonEndDate = Carbon::createFromFormat('d/m/Y H:i', $endDateTime);
            $endDate = $carbonEndDate->format('Y-m-d');
            $time_end = $carbonEndDate->format('H:i');
        }

        $dateRange = Carbon::parse($startDate)->daysUntil($endDate);

        // dd(count($dateRange),$startDate,$endDate ,$time_start ,$time_end);
        // $carbonStartDate = Carbon::createFromFormat('d/m/Y H:i', $startDateTime);
        // $startDate = $carbonStartDate->format('Y-m-d');
        // $time_start = $carbonStartDate->format('H:i');

        // $carbonEndDate = Carbon::createFromFormat('d/m/Y H:i', $endDateTime);
        // $endDate = $carbonEndDate->format('Y-m-d');
        // $time_end = $carbonEndDate->format('H:i');

        
        $approvedList = collect($userIds)->map(function ($userId) {
                return ['user_id' => $userId, 'status' => 0];
            });

            foreach ($dateRange as $date) {
                $name = $request->name . ' ' . $date->format('d/m/Y');
                OverTime::create([
                    'name' => $name,
                    'approver_id' => $approver->id,
                    'from_date' => $date->format('Y-m-d'),
                    'to_date' => $date->format('Y-m-d'),
                    'start_time' => $time_start,
                    'end_time' => $time_end,
                    'approved_list' => $approvedList->toJson(),
                    'type' => $type
                ]);
            }

        return redirect()->route('groups.document-system.overtime.document');
    }

    public function view($id)
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'update'
        $action = 'update';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $overtime = OverTime::find($id);
        $approvedList = json_decode($overtime->approved_list, true);
        $userIds = array_column($approvedList, 'user_id');

        $users = User::whereIn('id',$userIds)->get();

        return view('groups.document-system.overtime.document.view', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'overtime' => $overtime,
            'users' => $users
        ]);
    }

    public function update(Request $request,$id)
    {
        $validator = $this->validateFormData($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userIds = $request->userId;
        $startDateTime = $request->startDate;
        $endDateTime = $request->endDate;

        // Parse the startDate using Carbon
        $carbonStartDate = Carbon::createFromFormat('d/m/Y H:i', $startDateTime);
        $startDate = $carbonStartDate->format('Y-m-d');
        $time_start = $carbonStartDate->format('H:i');

        $carbonEndDate = Carbon::createFromFormat('d/m/Y H:i', $endDateTime);
        $endDate = $carbonEndDate->format('Y-m-d');
        $time_end = $carbonEndDate->format('H:i');

        $overtimeId = $id;
        $name = $request->name;

        $overTime = OverTime::find($overtimeId);

        // $userIds = $request->userId; // Example incoming user IDs
        $approvedList = json_decode($overTime->approved_list, true);
        $existingUserIds = array_column($approvedList, 'user_id');

        // Calculate the new list of user IDs
        $newUserIds = array_diff($userIds, $existingUserIds);
        
        // Remove user IDs that need to be removed
        $approvedList = array_filter($approvedList, function ($item) use ($userIds) {
            return in_array($item['user_id'], $userIds);
        });

        $newUserItems = collect($newUserIds)->map(function ($newUserId) {
            return ['user_id' => $newUserId, 'status' => 0];
        })->all();

        $approvedList = collect(array_merge($approvedList, $newUserItems));

        OverTime::find($overtimeId)->update([
            'name' => $name,
            'from_date' => $startDate,
            'to_date' => $endDate,
            'start_time' => $time_start,
            'end_time' => $time_end,
            'approved_list' => $approvedList->toJson(),
        ]);

        return redirect()->route('groups.document-system.overtime.document');
    }

    public function delete($id)
    {
        $overtime = OverTime::findOrFail($id);
        $this->activityLogger->log('ลบ', $overtime);
        $overtime->delete();
        return response()->json(['message' => 'การล่วงเวลาถูกลบออกเรียบร้อยแล้ว']);
    }

    public function validateFormData($request)
    {
        $rules = [
        'name' => 'required',
        // 'userId' => 'required|array|min:1',
        'startDate' => '',
        'endDate' => '',
        'manual_time' => ''
        ];

        if ($rules['manual_time'] == "1") {
            $rules['startDate'] = 'required|date_format:d/m/Y';
            $rules['endDate'] = 'required|date_format:d/m/Y|after_or_equal:startDate';
        } elseif ($rules['manual_time'] == "2") {
            $rules['startDate'] = 'required|date_format:d/m/Y H:i';
            $rules['endDate'] = 'required|date_format:d/m/Y H:i|after_or_equal:startDate';
        } 

        return Validator::make($request->all(), $rules);
    }

    public function getUsers(Request $request)
    {
        $users = User::where('nationality_id', 1)->where('ethnicity_id', 1)->get();
        return view('groups.document-system.overtime.document.modal-user-render.modal-user',['users' => $users])->render();
    }

    public function search(Request $request)
    {
        $companyDepartmentId = $request->data['companyDepartmentId'];
        $startDate = $request->data['startDate'];
        $endDate = $request->data['endDate'];

        $overtimes = $this->searchOvertime($companyDepartmentId,$startDate,$endDate);

        return view('groups.document-system.overtime.document.table-render.overtime-table', [
            'overtimes' => $overtimes,
        ])->render();

    }

    public function searchOvertime($companyDepartmentId,$startDate,$endDate){
        $overtimes = OverTime::where(function ($query) use ($startDate, $endDate,$companyDepartmentId) {
            if (!empty($startDate) && !empty($endDate)) {
                $startDate = Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
                $endDate = Carbon::createFromFormat('d/m/Y', $endDate)->format('Y-m-d');
                $query->whereBetween('from_date', [$startDate, $endDate]);
            } elseif (!empty($startDate)) {
                $startDate = Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
                $query->where('from_date', '>=', $startDate);
            } elseif (!empty($endDate)) {
                $endDate = Carbon::createFromFormat('d/m/Y', $endDate)->format('Y-m-d');
                $query->where('from_date', '<=', $endDate);
            }
            
            // Check if company_department_id is selected, if not, return all departments
            if (!empty($companyDepartmentId)) {
                $query->whereHas('approver', function ($subQuery) use ($companyDepartmentId) {
                    $subQuery->where('company_department_id', $companyDepartmentId);
                });
            }
        })->paginate(31);

        return $overtimes;
    }

    public function bulkDelete(Request $request){
        $companyDepartmentId = $request->data['companyDepartmentId'];
        $startDate = $request->data['startDate'];
        $endDate = $request->data['endDate'];

        $selectedOvertimes = $request->data['selectedOvertime'];
        OverTime::whereIn('id',$selectedOvertimes)->delete();

        $overtimes = $this->searchOvertime($companyDepartmentId,$startDate,$endDate);

        return view('groups.document-system.overtime.document.table-render.overtime-table', [
            'overtimes' => $overtimes,
        ])->render();
    }
}
