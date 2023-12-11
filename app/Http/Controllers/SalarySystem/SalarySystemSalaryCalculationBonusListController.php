<?php

namespace App\Http\Controllers\SalarySystem;
use PDF;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Bonus;
use App\Models\BonusUser;
use App\Models\TaxSetting;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use Illuminate\Validation\Rule;
use App\Models\CompanyDepartment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Helpers\AddDefaultWorkScheduleAssignment;
use App\Services\UpdatedRoleGroupCollectionService;

class SalarySystemSalaryCalculationBonusListController extends Controller
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
        // กำหนดค่าตัวแปร $action ให้เป็น 'show'
        $action = 'show';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission, viewName โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $viewName = $roleGroupCollection['viewName'];
        $bonuses = Bonus::all();
        
        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'bonuses' => $bonuses 
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

        return view('groups.salary-system.salary.calculation-bonus-list.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission
        ]);

    }

    public function store(Request $request){
        $validator = $this->validateFormData($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $name = $request->name;
        $issued = $request->issued;
        $description = $request->description;

        Bonus::create([
            'name' => $name,
            'issued' => Carbon::createFromFormat('d/m/Y', $issued)->format('Y-m-d'),
            'description' => $description,
        ]);

        return redirect()->route('groups.salary-system.salary.calculation-bonus-list');
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
        $bonus = Bonus::find($id);

        return view('groups.salary-system.salary.calculation-bonus-list.view', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'bonus' => $bonus
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validateFormData($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $name = $request->name;
        $issued = $request->issued;
        $description = $request->description;
        $status = $request->status;

        Bonus::find($id)->update([
            'name' => $name,
            'issued' => Carbon::createFromFormat('d/m/Y', $issued)->format('Y-m-d'),
            'description' => $description,
            'status' => $status,
        ]);
        return redirect()->route('groups.salary-system.salary.calculation-bonus-list');
    }

     public function delete($id)
    {
        $bonus = Bonus::findOrFail($id);

        $this->activityLogger->log('ลบ', $bonus);

        $bonus->delete();

        return response()->json(['message' => 'รายการโบนัสถูกลบออกเรียบร้อยแล้ว']);
    }

    public function downloadPdf($bonusId)
    {

        $userIds = BonusUser::where('bonus_id',$bonusId)->pluck('user_id')->toArray();
        $users = User::whereIn('id',$userIds)->get();
        $companyDepartmentIds = array_unique($users->pluck('company_department_id')->toArray());

        $companyDepartments = CompanyDepartment::whereIn('id',$companyDepartmentIds)->get();

        $bonusUsers = BonusUser::where('bonus_id',$bonusId)->get();
        $bonus = Bonus::find($bonusId);

        // dd($companyDepartments);
      
        $taxSetting = TaxSetting::first();
        $data = ['users'=>$users,'bonusUsers'=>$bonusUsers,'companyDepartments' => $companyDepartments,'bonus' => $bonus,'taxSetting' => $taxSetting];
        $pdf = PDF::loadView('groups.salary-system.salary.calculation-bonus-list.all-pdf', $data,[],[ 
          'title' => 'Certificate', 
          'format' => 'A4-L',
          'orientation' => 'L'
        ]);
        return $pdf->stream('document.pdf');
    }

    public function validateFormData($request)
    {
        // ตรวจสอบความถูกต้องของข้อมูลในฟอร์ม
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'issued' => 'date_format:d/m/Y',
        ]);

        // ส่งกลับตัว validator
        return $validator;
    }


}
