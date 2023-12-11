<?php
namespace App\Services;

use App\Models\Job;
use App\Models\Group;
use App\Models\Module;
use App\Models\RoleGroupJson;
use App\Services\AccessGroupService;
use Illuminate\Support\Facades\Route;

class UpdatedRoleGroupCollectionService
{
    private $accessGroupService;

    public function __construct(AccessGroupService $accessGroupService)
    {
        $this->accessGroupService = $accessGroupService;
    }
    public function getUpdatedRoleGroupCollection($action)
    {
        $user = auth()->user();
        
        $filterRoute = $this->filterRoute(Route::currentRouteName());
        $job = Job::where('route', $filterRoute)->first();

        // dd($filterRoute,$job);
       
        $groupId = $job->group_module_job->group_id;
        
        $moduleId = $job->group_module_job->module_id;
        $viewName = $job->view;
        $viewRoute = $job->route;

        $group = Group::findOrFail($groupId);
        $module = Module::findOrFail($moduleId);

        $this->accessGroupService->hasAccess($user, $group);
        $updatedRoleGroupCollection = $this->getRoleGroupJson($user, $group);

        $permission = $this->accessGroupService->hasPermission($updatedRoleGroupCollection, $module, $job, $action);

        return [
            'updatedRoleGroupCollection' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'viewName' => $viewName,
            'viewRoute' => $viewRoute,
        ];
    }

    public function filterRoute($route)
    {
        $parts = explode('.', $route);
        return implode('.', array_slice($parts, 0, 4));
    }

    public function getRoleGroupJson($user, $group)
    {
        $role = $user->roles->first();
        $roleGroupJson = json_decode(RoleGroupJson::where('role_id', $role->id)->where('group_id', $group->id)->first()->json);
        $roleGroupCollection = collect($roleGroupJson);
        $updatedRoleGroupCollection = $roleGroupCollection
            ->filter(function ($module) {
                return $module->enable === true || $module->enable === "true";
            })
            ->map(function ($module) {
                $module->jobs = collect($module->jobs)->map(function ($job) {
                    $jobModel = Job::find($job->job_id);
                    $job->job_view = $jobModel->view;
                    $job->job_route = $jobModel->route;
                    return $job;
                });

                $moduleModel = Module::find($module->module_id);
                $module->module_icon = $moduleModel->icon;
                $module->module_prefix = $moduleModel->prefix;
                return $module;
            });

        return $updatedRoleGroupCollection;
    }
}
