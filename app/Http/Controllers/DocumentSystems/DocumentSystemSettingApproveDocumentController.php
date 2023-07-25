<?php

namespace App\Http\Controllers\DocumentSystems;

use App\Models\User;
use App\Models\Approver;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Models\CompanyDepartment;
use App\Http\Controllers\Controller;
use App\Services\UpdatedRoleGroupCollectionService;
use Illuminate\Support\Facades\Validator;

class DocumentSystemSettingApproveDocumentController extends Controller
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
        $approvers = Approver::paginate(20);

        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'approvers' => $approvers
        ]);
    }
    public function create()
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'create'
        $action = 'show';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission, viewName โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        
        $documentTypes = DocumentType::all();
        $companyDepartments = CompanyDepartment::all();
        $approvers = User::where('nationality_id', 1)->where('ethnicity_id', 1)->get();

        return view('groups.document-system.setting.approve-document.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'documentTypes' => $documentTypes,
            'companyDepartments' => $companyDepartments,
            'approvers' => $approvers
        ]);
    }
    public function store(Request $request)
    {
        $validator = $this->validateFormData($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $approveName = $request->name;
        $companyDepartmentId = $request->company_department;
        $approverOneId = $request->approver_one;
        $approverTwoId = $request->approver_two ?? null;
        $documentType = $request->document_type;

        $approver = new Approver();
        $approver->name = $approveName;
        $approver->document_type_id = $documentType;
        $approver->company_department_id = $companyDepartmentId;
        $approver->approver_one_id = $approverOneId;
        $approver->approver_two_id = $approverTwoId;
        $approver->save();

        $this->activityLogger->log('เพิ่ม', $approver);

        return redirect()->route('groups.document-system.setting.approve-document')->with([
            'message' => 'นำเข้าข้อมูลเรียบร้อยแล้ว'
        ]);
    }

    public function view($id)
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'update'
        $action = 'update';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission, viewName โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $approver = Approver::find($id);
        $documentTypes = DocumentType::all();
        $companyDepartments = CompanyDepartment::all();
        $approvers = User::where('nationality_id', 1)->where('ethnicity_id', 1)->get();

        return view('setting.organization.approver.view', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'approver' => $approver,
            'documentTypes' => $documentTypes,
            'companyDepartments' => $companyDepartments,
            'approvers' => $approvers
        ]);
    }

    public function delete($id)
    {
        $approver = Approver::findOrFail($id);
        $this->activityLogger->log('ลบ', $approver);
        $approver->delete();

        return response()->json(['message' => 'การอนุมัติได้ถูกลบออกเรียบร้อยแล้ว']);
    }

    public function validateFormData($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'company_department.*' => 'required',
            'document_type.*' => 'required',
            'approver_one.*' => 'required'
        ]);

        return $validator;
    }
}
