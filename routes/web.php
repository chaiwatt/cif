<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\Jobs\ShiftController;
use App\Http\Controllers\Settings\SettingController;
use App\Http\Controllers\Settings\SettingAccessRoleController;
use App\Http\Controllers\settings\SettingReportUserController;
use App\Http\Controllers\Jobs\JobsShiftYearlyHolidayController;
use App\Http\Controllers\jobs\WorkScheduleAssignmentController;
use App\Http\Controllers\Jobs\JobsShiftTimeattendanceController;
use App\Http\Controllers\jobs\JobsScheduleWorkScheduleController;
use App\Http\Controllers\Settings\SettingAssignmentRoleController;
use App\Http\Controllers\Settings\SettingAssignmentGroupController;
use App\Http\Controllers\Settings\SettingAssignmentModuleController;
use App\Http\Controllers\Settings\SettingGeneralSearchFieldController;
use App\Http\Controllers\settings\SettingOrganizationApproverController;
use App\Http\Controllers\Settings\SettingOrganizationEmployeeController;
use App\Http\Controllers\SettingOrganizationApproverAssignmentController;
use App\Http\Controllers\settings\SettingGeneralSearchFieldUserController;
use App\Http\Controllers\jobs\JobsScheduleWorkScheduleAssignmentController;
use App\Http\Controllers\Settings\SettingGeneralCompanyDepartmentController;
use App\Http\Controllers\Settings\SettingOrganizationEmployeeImportController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', function () {
    return view('landing');
});
Route::get('isdatevalid', [TestController::class, 'isDateValid'])->name('isDateValid');
Route::group(['prefix' => 'shift'], function () {
    Route::get('', [ShiftController::class, 'index'])->name('shifts.index');
    Route::get('{id}', [ShiftController::class, 'view'])->name('shifts.view');
    Route::post('store', [ShiftController::class, 'store'])->name('shifts.store');
    Route::put('{id}', [ShiftController::class, 'update'])->name('shifts.update');
    Route::delete('{id}', [ShiftController::class, 'delete'])->name('shifts.delete');
});
Route::group(['prefix' => 'work_schedule'], function () {
    Route::get('', [WorkScheduleAssignmentController::class, 'index'])->name('work_schedule.index');
    Route::get('create', [WorkScheduleAssignmentController::class, 'create'])->name('work_schedule.create');
    Route::get('assign', [WorkScheduleAssignmentController::class, 'assign'])->name('work_schedule.assign');
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/group/{id}', [GroupController::class, 'index'])->name('group.index');
    Route::get('/log', [LogController::class, 'index'])->name('log');
    Route::group(['prefix' => 'jobs'], function () {
        Route::group(['prefix' => 'shift'], function () {
            Route::group(['prefix' => 'timeattendance'], function () {
                Route::get('', [JobsShiftTimeattendanceController::class, 'index'])->name('jobs.shift.timeattendance');
                Route::get('create', [JobsShiftTimeattendanceController::class, 'create'])->name('jobs.shift.timeattendance.create');
                Route::post('store', [JobsShiftTimeattendanceController::class, 'store'])->name('jobs.shift.timeattendance.store');
                Route::get('{id}', [JobsShiftTimeattendanceController::class, 'view'])->name('jobs.shift.timeattendance.view');
                Route::put('{id}', [JobsShiftTimeattendanceController::class, 'update'])->name('jobs.shift.timeattendance.update');
                Route::get('duplicate/{id}', [JobsShiftTimeattendanceController::class, 'duplicate'])->name('jobs.shift.timeattendance.duplicate');
                Route::delete('{id}', [JobsShiftTimeattendanceController::class, 'delete'])->name('jobs.shift.timeattendance.delete');
            });

            Route::group(['prefix' => 'yearlyholiday'], function () {
                Route::get('', [JobsShiftYearlyHolidayController::class, 'index'])->name('jobs.shift.yearlyholiday');
                Route::get('create', [JobsShiftYearlyHolidayController::class, 'create'])->name('jobs.shift.yearlyholiday.create');
                Route::post('store', [JobsShiftYearlyHolidayController::class, 'store'])->name('jobs.shift.yearlyholiday.store');
                Route::get('{id}', [JobsShiftYearlyHolidayController::class, 'view'])->name('jobs.shift.yearlyholiday.view');
                Route::put('{id}', [JobsShiftYearlyHolidayController::class, 'update'])->name('jobs.shift.yearlyholiday.update');
                Route::delete('{id}', [JobsShiftYearlyHolidayController::class, 'delete'])->name('jobs.shift.yearlyholiday.delete');
            });
        });
        Route::group(['prefix' => 'schedulework'], function () {
            Route::group(['prefix' => 'schedule'], function () {
                Route::get('', [JobsScheduleWorkScheduleController::class, 'index'])->name('jobs.schedulework.schedule');
                Route::get('create', [JobsScheduleWorkScheduleController::class, 'create'])->name('jobs.schedulework.schedule.create');
                Route::post('store', [JobsScheduleWorkScheduleController::class, 'store'])->name('jobs.schedulework.schedule.store');
                Route::group(['prefix' => 'assignment'], function () {
                    Route::get('view/{id}', [JobsScheduleWorkScheduleAssignmentController::class, 'view'])->name('jobs.schedulework.schedule.assignment');
                    Route::get('work-schedule/{workScheduleId}/year/{year}/month/{month}', [JobsScheduleWorkScheduleAssignmentController::class, 'create'])->name('jobs.schedulework.schedule.assignment.create');
                });
            });
        });
    });
    Route::group(['prefix' => 'setting', 'middleware' => 'admin'], function () {
        Route::get('', [SettingController::class, 'index'])->name('setting');
        Route::group(['prefix' => 'organization'], function () {
            Route::group(['prefix' => 'employee'], function () {
                Route::get('', [SettingOrganizationEmployeeController::class, 'index'])->name('setting.organization.employee.index');
                Route::get('create', [SettingOrganizationEmployeeController::class, 'create'])->name('setting.organization.employee.create');
                Route::post('store', [SettingOrganizationEmployeeController::class, 'store'])->name('setting.organization.employee.store');
                Route::get('{id}', [SettingOrganizationEmployeeController::class, 'view'])->name('setting.organization.employee.view');
                Route::put('{id}', [SettingOrganizationEmployeeController::class, 'update'])->name('setting.organization.employee.update');
                Route::delete('{id}', [SettingOrganizationEmployeeController::class, 'delete'])->name('setting.organization.employee.delete');
                Route::post('search', [SettingOrganizationEmployeeController::class, 'search'])->name('setting.organization.employee.search');
                
                Route::group(['prefix' => 'import'], function () {
                    Route::get('index', [SettingOrganizationEmployeeImportController::class, 'index'])->name('setting.organization.employee.import.index');
                    Route::post('store', [SettingOrganizationEmployeeImportController::class, 'store'])->name('setting.organization.employee.import.store');
                });
            });
            Route::group(['prefix' => 'approver'], function () {
                Route::get('', [SettingOrganizationApproverController::class, 'index'])->name('setting.organization.approver.index');
                Route::get('create', [SettingOrganizationApproverController::class, 'create'])->name('setting.organization.approver.create');
                Route::post('store', [SettingOrganizationApproverController::class, 'store'])->name('setting.organization.approver.store');
                Route::get('{id}', [SettingOrganizationApproverController::class, 'view'])->name('setting.organization.approver.view');
                Route::put('{id}', [SettingOrganizationApproverController::class, 'update'])->name('setting.organization.approver.update');
                Route::delete('{id}', [SettingOrganizationApproverController::class, 'delete'])->name('setting.organization.approver.delete');
                
                Route::group(['prefix' => 'assignment'], function () {
                    Route::get('{id}', [SettingOrganizationApproverAssignmentController::class, 'index'])->name('setting.organization.approver.assignment.index');
                    Route::get('create/{id}', [SettingOrganizationApproverAssignmentController::class, 'create'])->name('setting.organization.approver.assignment.create');
                    Route::post('store', [SettingOrganizationApproverAssignmentController::class, 'store'])->name('setting.organization.approver.assignment.store');
                    Route::delete('approves/{approver_id}/users/{user_id}/delete', [SettingOrganizationApproverAssignmentController::class, 'delete'])->name('setting.organization.approver.assignment.delete');
                    Route::post('search', [SettingOrganizationApproverAssignmentController::class, 'search'])->name('setting.organization.approver.assignment.search');
                    
                });
            });
        });
        Route::group(['prefix' => 'general'], function () {
            Route::group(['prefix' => 'companydepartment'], function () {
                Route::get('', [SettingGeneralCompanyDepartmentController::class, 'index'])->name('setting.general.companydepartment.index');
                Route::get('create', [SettingGeneralCompanyDepartmentController::class, 'create'])->name('setting.general.companydepartment.create');
                Route::post('store', [SettingGeneralCompanyDepartmentController::class, 'store'])->name('setting.general.companydepartment.store');
                Route::get('{id}', [SettingGeneralCompanyDepartmentController::class, 'view'])->name('setting.general.companydepartment.view');
                Route::put('{id}', [SettingGeneralCompanyDepartmentController::class, 'update'])->name('setting.general.companydepartment.update');
                Route::delete('{id}', [SettingGeneralCompanyDepartmentController::class, 'delete'])->name('setting.general.companydepartment.delete');
            });
            Route::group(['prefix' => 'searchfield'], function () {
                Route::get('', [SettingGeneralSearchFieldController::class, 'index'])->name('setting.general.searchfield.index');
                Route::group(['prefix' => 'user'], function () {
                    Route::post('update', [SettingGeneralSearchFieldUserController::class, 'update'])->name('setting.general.searchfield.user.update'); 
                });
            });
        });
        Route::group(['prefix' => 'access'], function () {
            Route::group(['prefix' => 'role'], function () {
                Route::get('', [SettingAccessRoleController::class, 'index'])->name('setting.access.role.index');
                Route::get('create', [SettingAccessRoleController::class, 'create'])->name('setting.access.role.create');
                Route::post('store', [SettingAccessRoleController::class, 'store'])->name('setting.access.role.store');
                Route::get('{id}', [SettingAccessRoleController::class, 'view'])->name('setting.access.role.view');
                Route::put('{id}', [SettingAccessRoleController::class, 'update'])->name('setting.access.role.update');
                Route::delete('{id}', [SettingAccessRoleController::class, 'delete'])->name('setting.access.role.delete');
            });
        });
        Route::group(['prefix' => 'assignment'], function () {
            Route::group(['prefix' => 'group'], function () {
                Route::post('store', [SettingAssignmentGroupController::class, 'store'])->name('setting.assignment.group.store');
                Route::delete('roles/{roleId}/groups/{groupId}/delete', [SettingAssignmentGroupController::class, 'delete'])->name('setting.assignment.group.delete');
                Route::get('{id}', [SettingAssignmentGroupController::class, 'view'])->name('setting.assignment.group.view');
            });
            Route::group(['prefix' => 'module'], function () {
                Route::get('{id}', [SettingAssignmentModuleController::class, 'view'])->name('setting.assignment.module.view');
                Route::post('module.update-module-json', [SettingAssignmentModuleController::class, 'updateModuleJson'])->name('setting.module.update-module-json');
            });
            Route::group(['prefix' => 'role'], function () {
                Route::post('store', [SettingAssignmentRoleController::class, 'store'])->name('setting.assignment.role.store');
                Route::get('roles/{roleId}/users/{userId}/delete', [SettingAssignmentRoleController::class, 'delete'])->name('setting.assignment.role.delete');
            });
        });
        Route::group(['prefix' => 'report'], function () {
            Route::group(['prefix' => 'user'], function () {
                Route::get('', [SettingReportUserController::class, 'index'])->name('setting.report.user');
                Route::post('export', [SettingReportUserController::class, 'export'])->name('setting.report.user.export');
                Route::post('search', [SettingReportUserController::class, 'search'])->name('setting.report.user.search');
                Route::post('report-field', [SettingReportUserController::class, 'getReportField'])->name('setting.report.user.report-field');
                Route::post('update-report-field', [SettingReportUserController::class, 'updateReportField'])->name('setting.report.user.update-report-field');
                Route::post('report-search', [SettingReportUserController::class, 'reportSearch'])->name('setting.report.user.report-search');
            });
        });
    });

    Route::group(['prefix' => 'api'], function () {
        Route::get('get-group', [ApiController::class, 'getGroup'])->name('api.get-group');
        Route::post('get-module-json', [ApiController::class, 'getModuleJson'])->name('api.get-module-json');
        Route::get('get-user', [ApiController::class, 'getUser'])->name('api.get-user');
    });
});

