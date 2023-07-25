<?php

namespace App\Http\Controllers\DocumentSystems;

use App\Models\User;
use App\Models\Approver;
use App\Models\SearchField;
use App\Models\ApproverUser;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Services\UpdatedRoleGroupCollectionService;

class DocumentSystemSettingApproveDocumentAssignmentController extends Controller
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

        $approver = Approver::find($id);
        return view('groups.document-system.setting.approve-document.assignment.index', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'approver' => $approver
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

        $approver = Approver::find($id);

        $users = User::whereDoesntHave('approvers', function ($query) use ($id) {
            $query->where('approver_id', $id);
        })->paginate(50);
        
        return view('groups.document-system.setting.approve-document.assignment.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'users' => $users,
            'approver' => $approver
        ]);
    }

      public function store(Request $request)
    {
        $selectedUsers = $request->users;
        $approverId = $request->approverId;

        $approver = Approver::find($approverId);
        $approver->users()->attach($selectedUsers);

        return redirect()->to('groups/document-system/setting/approve-document/assignment/' . $approverId);
    }

    public function search(Request $request)
    {
        $queryInput = $request->data['searchInput'];
        $approverId = $request->data['approverId'];
        
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
        $approversUserIds = ApproverUser::where('approver_id', $approverId)->pluck('user_id');

        $filteredUserIds = $userIds->diff($approversUserIds);

        $users = User::whereIn('id', $filteredUserIds)->paginate(50);

        return view('groups.document-system.setting.approve-document.assignment.table-render.employee-table', ['users' => $users])->render();
    }

    public function delete(Request $request, $approverId, $userId)
    {
        $approver = Approver::findOrFail($approverId);
        $user = User::findOrFail($userId);

        $approver->users()->detach($user);

        return redirect()->to('groups/document-system/setting/approve-document/assignment/' . $approverId);
    }
}
