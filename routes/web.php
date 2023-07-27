<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\settings\SettingController;
use App\Http\Controllers\settings\SettingReportLogController;
use App\Http\Controllers\settings\SettingAccessRoleController;
use App\Http\Controllers\settings\SettingReportUserController;
use App\Http\Controllers\TimeRecordingSystems\ShiftController;
use App\Http\Controllers\settings\SettingReportExpirationController;
use App\Http\Controllers\settings\SettingGeneralSearchFieldController;
use App\Http\Controllers\settings\SettingAccessAssignmentRoleController;
use App\Http\Controllers\settings\SettingOrganizationApproverController;
use App\Http\Controllers\settings\SettingOrganizationEmployeeController;
use App\Http\Controllers\SalarySystem\SalarySystemSettingPaydayController;
use App\Http\Controllers\settings\SettingGeneralSearchFieldUserController;
use App\Http\Controllers\settings\SettingGeneralCompanyDepartmentController;
use App\Http\Controllers\settings\SettingOrganizationEmployeeImportController;
use App\Http\Controllers\settings\SettingAccessAssignmentGroupModuleController;
use App\Http\Controllers\TimeRecordingSystems\WorkScheduleAssignmentController;
use App\Http\Controllers\settings\SettingOrganizationApproverAssignmentController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemReportController;
use App\Http\Controllers\DocumentSystems\DocumentSystemSettingApproveDocumentController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemShiftYearlyHolidayController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemShiftTimeattendanceController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemScheduleWorkScheduleController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemSettingEmployeeGroupController;
use App\Http\Controllers\DocumentSystems\DocumentSystemSettingApproveDocumentAssignmentController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemScheduleWorkTimeRecordingController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemSettingWorkScheduleVisibilityController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemScheduleWorkScheduleAssignmentController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemScheduleWorkTimeRecordingCheckController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemSettingEmployeeGroupAssignmentController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemScheduleWorkTimeRecordingImportController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemScheduleWorkScheduleAssignmentUserController;


Auth::routes();

Route::get('/', function () {
    return view('landing');
});
Route::get('isdatevalid', [TestController::class, 'isDateValid'])->name('isDateValid');
Route::get('clear-db', [TestController::class, 'clearDB'])->name('clear-db');
Route::get('test', [TestController::class, 'testRoute'])->name('test');

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

    Route::group(['prefix' => 'groups'], function () {
        Route::group(['prefix' => 'time-recording-system'], function () {
            Route::group(['prefix' => 'shift'], function () {
                Route::group(['prefix' => 'timeattendance'], function () {
                    Route::get('', [TimeRecordingSystemShiftTimeattendanceController::class, 'index'])->name('groups.time-recording-system.shift.timeattendance');
                    Route::get('create', [TimeRecordingSystemShiftTimeattendanceController::class, 'create'])->name('groups.time-recording-system.shift.timeattendance.create');
                    Route::post('store', [TimeRecordingSystemShiftTimeattendanceController::class, 'store'])->name('groups.time-recording-system.shift.timeattendance.store');
                    Route::get('{id}', [TimeRecordingSystemShiftTimeattendanceController::class, 'view'])->name('groups.time-recording-system.shift.timeattendance.view');
                    Route::put('{id}', [TimeRecordingSystemShiftTimeattendanceController::class, 'update'])->name('groups.time-recording-system.shift.timeattendance.update');
                    Route::get('duplicate/{id}', [TimeRecordingSystemShiftTimeattendanceController::class, 'duplicate'])->name('groups.time-recording-system.shift.timeattendance.duplicate');
                    Route::delete('{id}', [TimeRecordingSystemShiftTimeattendanceController::class, 'delete'])->name('groups.time-recording-system.shift.timeattendance.delete');
                    Route::post('search', [TimeRecordingSystemShiftTimeattendanceController::class, 'search'])->name('groups.time-recording-system.shift.timeattendance.search');
                });

                Route::group(['prefix' => 'yearlyholiday'], function () {
                    Route::get('', [TimeRecordingSystemShiftYearlyHolidayController::class, 'index'])->name('groups.time-recording-system.shift.yearlyholiday');
                    Route::get('create', [TimeRecordingSystemShiftYearlyHolidayController::class, 'create'])->name('groups.time-recording-system.shift.yearlyholiday.create');
                    Route::post('store', [TimeRecordingSystemShiftYearlyHolidayController::class, 'store'])->name('groups.time-recording-system.shift.yearlyholiday.store');
                    Route::get('{id}', [TimeRecordingSystemShiftYearlyHolidayController::class, 'view'])->name('groups.time-recording-system.shift.yearlyholiday.view');
                    Route::put('{id}', [TimeRecordingSystemShiftYearlyHolidayController::class, 'update'])->name('groups.time-recording-system.shift.yearlyholiday.update');
                    Route::delete('{id}', [TimeRecordingSystemShiftYearlyHolidayController::class, 'delete'])->name('groups.time-recording-system.shift.yearlyholiday.delete');
                    Route::post('search', [TimeRecordingSystemShiftYearlyHolidayController::class, 'search'])->name('groups.time-recording-system.shift.yearlyholiday.search');
                });
            });
            Route::group(['prefix' => 'schedulework'], function () {
                Route::group(['prefix' => 'schedule'], function () {
                    Route::get('', [TimeRecordingSystemScheduleWorkScheduleController::class, 'index'])->name('groups.time-recording-system.schedulework.schedule');
                    Route::get('create', [TimeRecordingSystemScheduleWorkScheduleController::class, 'create'])->name('groups.time-recording-system.schedulework.schedule.create');
                    Route::post('store', [TimeRecordingSystemScheduleWorkScheduleController::class, 'store'])->name('groups.time-recording-system.schedulework.schedule.store');
                    Route::get('{id}', [TimeRecordingSystemScheduleWorkScheduleController::class, 'view'])->name('groups.time-recording-system.schedulework.schedule.view');
                    Route::put('{id}', [TimeRecordingSystemScheduleWorkScheduleController::class, 'update'])->name('groups.time-recording-system.schedulework.schedule.update');
                    Route::delete('{id}', [TimeRecordingSystemScheduleWorkScheduleController::class, 'delete'])->name('groups.time-recording-system.schedulework.schedule.delete');
                    Route::post('search', [TimeRecordingSystemScheduleWorkScheduleController::class, 'search'])->name('groups.time-recording-system.schedulework.schedule.search');
                    Route::group(['prefix' => 'assignment'], function () {
                        Route::get('view/{id}', [TimeRecordingSystemScheduleWorkScheduleAssignmentController::class, 'view'])->name('groups.time-recording-system.schedulework.schedule.assignment');
                        Route::get('work-schedule/{workScheduleId}/year/{year}/month/{month}', [TimeRecordingSystemScheduleWorkScheduleAssignmentController::class, 'createWorkSchedule'])->name('groups.time-recording-system.schedulework.schedule.assignment.work-schedule');
                        Route::post('store-calendar', [TimeRecordingSystemScheduleWorkScheduleAssignmentController::class, 'storeCalendar'])->name('groups.time-recording-system.schedulework.schedule.assignment.work-schedule.store');


                        Route::group(['prefix' => 'user'], function () {
                            Route::get('{workScheduleId}/year/{year}/month/{month}', [TimeRecordingSystemScheduleWorkScheduleAssignmentUserController::class, 'index'])->name('groups.time-recording-system.schedulework.schedule.assignment.user');
                            Route::get('users/{workScheduleId}/year/{year}/month/{month}', [TimeRecordingSystemScheduleWorkScheduleAssignmentUserController::class, 'create'])->name('groups.time-recording-system.schedulework.schedule.assignment.user.create');
                            Route::post('store', [TimeRecordingSystemScheduleWorkScheduleAssignmentUserController::class, 'store'])->name('groups.time-recording-system.schedulework.schedule.assignment.user.store');
                            Route::post('import-user-group', [TimeRecordingSystemScheduleWorkScheduleAssignmentUserController::class, 'importUserGroup'])->name('groups.time-recording-system.schedulework.schedule.assignment.user.import-user-group');
                            Route::post('search', [TimeRecordingSystemScheduleWorkScheduleAssignmentUserController::class, 'search'])->name('groups.time-recording-system.schedulework.schedule.assignment.user.search');
                            Route::delete('work_schedule_id/{workScheduleId}/year/{year}/month/{month}/user_id/{userId}/delete', [TimeRecordingSystemScheduleWorkScheduleAssignmentUserController::class, 'delete'])->name('groups.time-recording-system.schedulework.schedule.assignment.user.delete');
                        });
                    });
                });
                Route::group(['prefix' => 'time-recording'], function () {
                    Route::get('', [TimeRecordingSystemScheduleWorkTimeRecordingController::class, 'index'])->name('groups.time-recording-system.schedulework.time-recording');
                    Route::post('search', [TimeRecordingSystemScheduleWorkTimeRecordingController::class, 'search'])->name('groups.time-recording-system.schedulework.time-recording.search');
                    Route::group(['prefix' => 'import'], function () {
                        Route::get('{workScheduleId}/year/{year}/month/{month}', [TimeRecordingSystemScheduleWorkTimeRecordingImportController::class, 'index'])->name('groups.time-recording-system.schedulework.time-recording.import');
                        Route::post('batch', [TimeRecordingSystemScheduleWorkTimeRecordingImportController::class, 'batch'])->name('groups.time-recording-system.schedulework.time-recording.import.batch');
                        Route::post('single', [TimeRecordingSystemScheduleWorkTimeRecordingImportController::class, 'single'])->name('groups.time-recording-system.schedulework.time-recording.import.single');
                        // Route::get('show-info', [TimeRecordingSystemScheduleWorkTimeRecordingImportController::class, 'showInfo'])->name('groups.time-recording-system.schedulework.time-recording.import.show-info');
                    });
                });
                Route::group(['prefix' => 'time-recording-check'], function () {
                    Route::get('', [TimeRecordingSystemScheduleWorkTimeRecordingCheckController::class, 'index'])->name('groups.time-recording-system.schedulework.time-recording-check');
                    Route::post('search', [TimeRecordingSystemScheduleWorkTimeRecordingCheckController::class, 'search'])->name('groups.time-recording-system.schedulework.time-recording-check.search');
                    Route::get('{workScheduleId}/year/{year}/month/{month}', [TimeRecordingSystemScheduleWorkTimeRecordingCheckController::class, 'view'])->name('groups.time-recording-system.schedulework.time-recording-check.view');
                    Route::post('time-record-check', [TimeRecordingSystemScheduleWorkTimeRecordingCheckController::class, 'timeRecordCheck'])->name('groups.time-recording-system.schedulework.time-recording-check.time-record-check');
                    Route::post('view-user', [TimeRecordingSystemScheduleWorkTimeRecordingCheckController::class, 'viewUser'])->name('groups.time-recording-system.schedulework.time-recording-check.view-user');
                    Route::post('update', [TimeRecordingSystemScheduleWorkTimeRecordingCheckController::class, 'update'])->name('groups.time-recording-system.schedulework.time-recording-check.update');
                });
            });
            Route::group(['prefix' => 'setting'], function () {
                Route::group(['prefix' => 'work-schedule-visibility'], function () {
                    Route::get('', [TimeRecordingSystemSettingWorkScheduleVisibilityController::class, 'index'])->name('groups.time-recording-system.setting.work-schedule-visibility');
                    Route::post('store', [TimeRecordingSystemSettingWorkScheduleVisibilityController::class, 'store'])->name('groups.time-recording-system.setting.work-schedule-visibility.store');
                });
                Route::group(['prefix' => 'employee-group'], function () {
                    Route::get('', [TimeRecordingSystemSettingEmployeeGroupController::class, 'index'])->name('groups.time-recording-system.setting.employee-group');
                    Route::get('create', [TimeRecordingSystemSettingEmployeeGroupController::class, 'create'])->name('groups.time-recording-system.setting.employee-group.create');
                    Route::post('store', [TimeRecordingSystemSettingEmployeeGroupController::class, 'store'])->name('groups.time-recording-system.setting.employee-group.store');
                    Route::get('{id}', [TimeRecordingSystemSettingEmployeeGroupController::class, 'view'])->name('groups.time-recording-system.setting.employee-group.view');
                    Route::put('{id}', [TimeRecordingSystemSettingEmployeeGroupController::class, 'update'])->name('groups.time-recording-system.setting.employee-group.update');
                    Route::delete('{id}', [TimeRecordingSystemSettingEmployeeGroupController::class, 'delete'])->name('groups.time-recording-system.setting.employee-group.delete');
                    Route::group(['prefix' => 'assignment'], function () {
                        Route::get('{id}', [TimeRecordingSystemSettingEmployeeGroupAssignmentController::class, 'index'])->name('groups.time-recording-system.setting.employee-group.assignment');
                        Route::delete('usergroups/{user_group_id}/users/{user_id}/delete', [TimeRecordingSystemSettingEmployeeGroupAssignmentController::class, 'delete'])->name('groups.time-recording-system.setting.employee-group.assignment.delete');
                        Route::get('create/{id}', [TimeRecordingSystemSettingEmployeeGroupAssignmentController::class, 'create'])->name('groups.time-recording-system.setting.employee-group.assignment.create');
                        Route::post('search', [TimeRecordingSystemSettingEmployeeGroupAssignmentController::class, 'search'])->name('groups.time-recording-system.setting.employee-group.assignment.search');
                        Route::post('store', [TimeRecordingSystemSettingEmployeeGroupAssignmentController::class, 'store'])->name('groups.time-recording-system.setting.employee-group.assignment.store');
                    });
                });
            });
            Route::group(['prefix' => 'report'], function () {
                Route::get('', [TimeRecordingSystemReportController::class, 'index'])->name('groups.time-recording-system.report');
            });
        });
        Route::group(['prefix' => 'salary-system'], function () {
            Route::group(['prefix' => 'setting'], function () {
                Route::group(['prefix' => 'payday'], function () {
                    Route::get('', [SalarySystemSettingPaydayController::class, 'index'])->name('groups.salary-system.setting.payday');
                    Route::get('create', [SalarySystemSettingPaydayController::class, 'create'])->name('groups.salary-system.setting.payday.create');
                    Route::post('store', [SalarySystemSettingPaydayController::class, 'store'])->name('groups.salary-system.setting.payday.store');
                    Route::get('{id}', [SalarySystemSettingPaydayController::class, 'view'])->name('groups.salary-system.setting.payday.view');
                    Route::put('{id}', [SalarySystemSettingPaydayController::class, 'update'])->name('groups.salary-system.setting.payday.update');
                    Route::delete('{id}', [SalarySystemSettingPaydayController::class, 'delete'])->name('groups.salary-system.setting.payday.delete');
                });
            });
        });
        Route::group(['prefix' => 'document-system'], function () {
            Route::group(['prefix' => 'setting'], function () {
                Route::group(['prefix' => 'approve-document'], function () {
                    Route::get('', [DocumentSystemSettingApproveDocumentController::class, 'index'])->name('groups.document-system.setting.approve-document');
                    Route::get('create', [DocumentSystemSettingApproveDocumentController::class, 'create'])->name('groups.document-system.setting.approve-document.create');
                    Route::post('store', [DocumentSystemSettingApproveDocumentController::class, 'store'])->name('groups.document-system.setting.approve-document.store');
                    Route::get('{id}', [DocumentSystemSettingApproveDocumentController::class, 'view'])->name('groups.document-system.setting.approve-document.view');
                    Route::put('{id}', [DocumentSystemSettingApproveDocumentController::class, 'update'])->name('groups.document-system.setting.approve-document.update');
                    Route::delete('{id}', [DocumentSystemSettingApproveDocumentController::class, 'delete'])->name('groups.document-system.setting.approve-document.delete');

                    Route::group(['prefix' => 'assignment'], function () {
                        Route::get('{id}', [DocumentSystemSettingApproveDocumentAssignmentController::class, 'index'])->name('groups.document-system.setting.approve-document.assignment.index');
                        Route::get('create/{id}', [DocumentSystemSettingApproveDocumentAssignmentController::class, 'create'])->name('groups.document-system.setting.approve-document.assignment.create');
                        Route::post('store', [DocumentSystemSettingApproveDocumentAssignmentController::class, 'store'])->name('groups.document-system.setting.approve-document.assignment.store');
                        Route::delete('approves/{approver_id}/users/{user_id}/delete', [DocumentSystemSettingApproveDocumentAssignmentController::class, 'delete'])->name('groups.document-system.setting.approve-document.assignment.delete');
                        Route::post('search', [DocumentSystemSettingApproveDocumentAssignmentController::class, 'search'])->name('groups.document-system.setting.approve-document.assignment.search');

                    });
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
            Route::group(['prefix' => 'assignment'], function () {
                Route::group(['prefix' => 'group-module'], function () {
                    Route::post('store', [SettingAccessAssignmentGroupModuleController::class, 'store'])->name('setting.access.assignment.group-module.store');
                    Route::delete('roles/{roleId}/groups/{groupId}/delete', [SettingAccessAssignmentGroupModuleController::class, 'delete'])->name('setting.access.assignment.group-module.delete');
                    Route::get('{id}', [SettingAccessAssignmentGroupModuleController::class, 'view'])->name('setting.access.assignment.group-module.view');
                    Route::post('update-module-json', [SettingAccessAssignmentGroupModuleController::class, 'updateModuleJson'])->name('setting.access.assignment.group-module.update-module-json');
                });

                Route::group(['prefix' => 'role'], function () {
                    Route::post('store', [SettingAccessAssignmentRoleController::class, 'store'])->name('setting.access.assignment.role.store');
                    Route::get('roles/{roleId}/users/{userId}/delete', [SettingAccessAssignmentRoleController::class, 'delete'])->name('setting.access.assignment.role.delete');
                });
            });
        });

        Route::group(['prefix' => 'report'], function () {
            Route::group(['prefix' => 'user'], function () {
                Route::get('', [SettingReportUserController::class, 'index'])->name('setting.report.user');
                Route::post('export', [SettingReportUserController::class, 'export'])->name('setting.report.user.export');
                Route::post('search', [SettingReportUserController::class, 'search'])->name('setting.report.user.search');
                Route::get('report-field', [SettingReportUserController::class, 'getReportField'])->name('setting.report.user.report-field');
                Route::post('update-report-field', [SettingReportUserController::class, 'updateReportField'])->name('setting.report.user.update-report-field');
                Route::post('report-search', [SettingReportUserController::class, 'reportSearch'])->name('setting.report.user.report-search');
            });
            Route::group(['prefix' => 'log'], function () {
                Route::get('', [SettingReportLogController::class, 'index'])->name('setting.report.log');
                Route::post('search', [SettingReportLogController::class, 'search'])->name('setting.report.log.search');
            });
            Route::group(['prefix' => 'expiration'], function () {
                Route::get('', [SettingReportExpirationController::class, 'index'])->name('setting.report.expiration');
                Route::post('search', [SettingReportExpirationController::class, 'search'])->name('setting.report.expiration.search');
            });

        });
    });

    Route::group(['prefix' => 'api'], function () {
        Route::get('get-group', [ApiController::class, 'getGroup'])->name('api.get-group');
        Route::post('get-module-json', [ApiController::class, 'getModuleJson'])->name('api.get-module-json');
        Route::get('get-user', [ApiController::class, 'getUser'])->name('api.get-user');
    });
});

