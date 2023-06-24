<?php

namespace App\Http\Controllers\jobs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AccessGroupService;
use App\Services\UpdatedRoleGroupCollectionService;

class JobsScheduleWorkScheduleController extends Controller
{
    private $updatedRoleGroupCollectionService;
    private $accessGroupService;

    public function __construct(
        UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService,
        AccessGroupService $accessGroupService
    ) {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
        $this->accessGroupService = $accessGroupService;
    }
    
    public function index()
    {
        $action = 'show';
        $groupUrl = session('groupUrl');

        $updatedRoleGroupCollectionService = app(UpdatedRoleGroupCollectionService::class);
        $roleGroupCollection = $updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $viewName = $roleGroupCollection['viewName'];

        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission
        ]);
    }
}
