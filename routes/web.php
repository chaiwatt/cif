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
use App\Http\Controllers\settings\SettingOrganizationCompanyController;
use App\Http\Controllers\settings\SettingAccessAssignmentRoleController;
use App\Http\Controllers\settings\SettingOrganizationApproverController;
use App\Http\Controllers\settings\SettingOrganizationEmployeeController;
use App\Http\Controllers\SalarySystem\SalarySystemSalarySummaryController;
use App\Http\Controllers\SalarySystem\SalarySystemSettingPaydayController;
use App\Http\Controllers\settings\SettingGeneralSearchFieldUserController;
use App\Http\Controllers\settings\SettingGeneralCompanyDepartmentController;
use App\Http\Controllers\SalarySystem\SalarySystemSalaryCalculationController;
use App\Http\Controllers\SalarySystem\SalarySystemSettingIncomeDuctController;
use App\Http\Controllers\settings\SettingOrganizationEmployeeImportController;
use App\Http\Controllers\AssessmentSystem\AssessmentSystemAssessmentController;
use App\Http\Controllers\DocumentSystems\DocumentSystemLeaveApprovalController;
use App\Http\Controllers\DocumentSystems\DocumentSystemLeaveDocumentController;
use App\Http\Controllers\settings\SettingAccessAssignmentGroupModuleController;
use App\Http\Controllers\TimeRecordingSystems\WorkScheduleAssignmentController;
use App\Http\Controllers\AnnounceSystem\AnnounceSystemSettingCategoryController;
use App\Http\Controllers\AssessmentSystem\AssessmentSystemSettingScoreController;
use App\Http\Controllers\DocumentSystems\DocumentSystemOvertimeApprovalController;
use App\Http\Controllers\DocumentSystems\DocumentSystemOvertimeDocumentController;
use App\Http\Controllers\SalarySystem\SalarySystemSalaryCalculationListController;
use App\Http\Controllers\SalarySystem\SalarySystemSettingSkillBasedCostController;
use App\Http\Controllers\settings\SettingOrganizationApproverAssignmentController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemReportController;
use App\Http\Controllers\AssessmentSystem\AssessmentSystemSettingCriteriaController;
use App\Http\Controllers\AssessmentSystemSettingAssessmentGroupAssignmentController;
use App\Http\Controllers\SalarySystem\SalarySystemSettingPaydayAssignmentController;
use App\Http\Controllers\AssessmentSystem\AssessmentSystemSettingAssessmentController;
use App\Http\Controllers\JobApplication\JobApplicationSystemSettingCategoryController;
use App\Http\Controllers\SalarySystem\SalarySystemSettingDiligenceAllowanceController;
use App\Http\Controllers\SalarySystem\SalarySystemSalaryCalculationExtraListController;
use App\Http\Controllers\DocumentSystems\DocumentSystemSettingApproveDocumentController;
use App\Http\Controllers\SalarySystem\SalarySystemSettingPaydayAssignmentUserController;
use App\Http\Controllers\AssessmentSystem\AssessmentSystemAssessmentAssignmentController;
use App\Http\Controllers\SalarySystem\SalarySystemSalaryCalculationInformationController;
use App\Http\Controllers\SalarySystem\SalarySystemSalaryCalculationListSummaryController;
use App\Http\Controllers\SalarySystem\SalarySystemSalaryIncomeDeductAssignmentController;
use App\Http\Controllers\AssessmentSystem\AssessmentSystemSettingMultiplicationController;
use App\Http\Controllers\AssessmentSystem\AssessmentSystemSettingAssessmentGroupController;
use App\Http\Controllers\DocumentSystems\DocumentSystemOvertimeApprovalAssignmentController;
use App\Http\Controllers\UserManagementSystem\UserManagementSystemSettingUserInfoController;
use App\Http\Controllers\SalarySystem\SalarySystemSalaryCalculationListCalculationController;
use App\Http\Controllers\UserManagementSystem\UserManagementSystemSettingUserLeaveController;
use App\Http\Controllers\SalarySystem\SalarySystemSalaryCalculationExtraListSummaryController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemShiftYearlyHolidayController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemShiftTimeattendanceController;
use App\Http\Controllers\AssessmentSystem\AssessmentSystemAssessmentAssignmentScoringController;
use App\Http\Controllers\SalarySystem\SalarySystemSettingDiligenceAllowanceAssignmentController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemScheduleWorkScheduleController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemSettingEmployeeGroupController;
use App\Http\Controllers\DocumentSystems\DocumentSystemSettingApproveDocumentAssignmentController;
use App\Http\Controllers\SalarySystem\SalarySystemSalaryCalculationExtraListCalculationController;
use App\Http\Controllers\UserManagementSystem\UserManagementSystemSettingUserInfoSalaryController;
use App\Http\Controllers\UserManagementSystem\UserManagementSystemSettingUserInfoPositionController;
use App\Http\Controllers\UserManagementSystem\UserManagementSystemSettingUserInfoTrainingController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemScheduleWorkTimeRecordingController;
use App\Http\Controllers\TimeRecordingSystems\UserManagementSystemSettingUserInfAttachmentController;
use App\Http\Controllers\UserManagementSystem\UserManagementSystemSettingUserInfoEducationController;
use App\Http\Controllers\UserManagementSystem\UserManagementSystemSettingUserInfoPunishmentController;
use App\Http\Controllers\UserManagementSystem\UserManagementSystemSettingUserInfoWorkscheduleController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemSettingWorkScheduleVisibilityController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemScheduleWorkScheduleAssignmentController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemScheduleWorkTimeRecordingCheckController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemSettingEmployeeGroupAssignmentController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemScheduleWorkTimeRecordingImportController;
use App\Http\Controllers\SalarySystem\SalarySystemSalaryCalculationExtraListCalculationInformationController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemScheduleWorkScheduleAssignmentUserController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemScheduleWorkTimeRecordingCurrentPaydayController;
use App\Http\Controllers\UserManagementSystem\UserManagementSystemSettingUserInfDiligenceAllowanceClassifyController;
use App\Http\Controllers\TimeRecordingSystems\TimeRecordingSystemScheduleWorkTimeRecordingCheckCurrentPaydayController;


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
                            Route::post('import-employee-no', [TimeRecordingSystemScheduleWorkScheduleAssignmentUserController::class, 'importEmployeeNo'])->name('groups.time-recording-system.schedulework.schedule.assignment.user.import-employee-no');
                        });
                    });
                });
                Route::group(['prefix' => 'time-recording'], function () {
                    Route::get('', [TimeRecordingSystemScheduleWorkTimeRecordingController::class, 'index'])->name('groups.time-recording-system.schedulework.time-recording');
                    Route::post('search', [TimeRecordingSystemScheduleWorkTimeRecordingController::class, 'search'])->name('groups.time-recording-system.schedulework.time-recording.search');
                    Route::group(['prefix' => 'import'], function () {
                        Route::get('{workScheduleId}/year/{year}/month/{month}', [TimeRecordingSystemScheduleWorkTimeRecordingImportController::class, 'index'])->name('groups.time-recording-system.schedulework.time-recording.import');
                        Route::post('batch', [TimeRecordingSystemScheduleWorkTimeRecordingImportController::class, 'batch'])->name('groups.time-recording-system.schedulework.time-recording.import.batch');
                        Route::post('batch-auto-detect', [TimeRecordingSystemScheduleWorkTimeRecordingImportController::class, 'batchAutoDetect'])->name('groups.time-recording-system.schedulework.time-recording.import.batch-auto-detect');
                        Route::post('single', [TimeRecordingSystemScheduleWorkTimeRecordingImportController::class, 'single'])->name('groups.time-recording-system.schedulework.time-recording.import.single');
                    });
                });
                Route::group(['prefix' => 'time-recording-current-payday'], function () {
                    Route::get('', [TimeRecordingSystemScheduleWorkTimeRecordingCurrentPaydayController::class, 'index'])->name('groups.time-recording-system.schedulework.time-recording-current-payday');
                });
                Route::group(['prefix' => 'time-recording-check'], function () {
                    Route::get('', [TimeRecordingSystemScheduleWorkTimeRecordingCheckController::class, 'index'])->name('groups.time-recording-system.schedulework.time-recording-check');
                    Route::post('search', [TimeRecordingSystemScheduleWorkTimeRecordingCheckController::class, 'search'])->name('groups.time-recording-system.schedulework.time-recording-check.search');
                    Route::get('{workScheduleId}/year/{year}/month/{month}', [TimeRecordingSystemScheduleWorkTimeRecordingCheckController::class, 'view'])->name('groups.time-recording-system.schedulework.time-recording-check.view');
                    Route::post('time-record-check', [TimeRecordingSystemScheduleWorkTimeRecordingCheckController::class, 'timeRecordCheck'])->name('groups.time-recording-system.schedulework.time-recording-check.time-record-check');
                    Route::post('view-user', [TimeRecordingSystemScheduleWorkTimeRecordingCheckController::class, 'viewUser'])->name('groups.time-recording-system.schedulework.time-recording-check.view-user');
                    Route::post('update', [TimeRecordingSystemScheduleWorkTimeRecordingCheckController::class, 'update'])->name('groups.time-recording-system.schedulework.time-recording-check.update');
                    Route::post('save-note', [TimeRecordingSystemScheduleWorkTimeRecordingCheckController::class, 'saveNote'])->name('groups.time-recording-system.schedulework.time-recording-check.save-note');
                    Route::post('get-image', [TimeRecordingSystemScheduleWorkTimeRecordingCheckController::class, 'getImage'])->name('groups.time-recording-system.schedulework.time-recording-check.get-image');
                    Route::post('upload-image', [TimeRecordingSystemScheduleWorkTimeRecordingCheckController::class, 'uploadImage'])->name('groups.time-recording-system.schedulework.time-recording-check.upload-image');
                    Route::post('delete-image', [TimeRecordingSystemScheduleWorkTimeRecordingCheckController::class, 'deleteImage'])->name('groups.time-recording-system.schedulework.time-recording-check.delete-image');
                    Route::post('get-leave-attachment', [TimeRecordingSystemScheduleWorkTimeRecordingCheckController::class, 'getLeaveAttachment'])->name('groups.time-recording-system.schedulework.time-recording-check.get-leave-attachment');
                });
                Route::group(['prefix' => 'time-recording-check-current-payday'], function () {
                    Route::get('', [TimeRecordingSystemScheduleWorkTimeRecordingCheckCurrentPaydayController::class, 'index'])->name('groups.time-recording-system.schedulework.time-recording-check-current-payday');
                    Route::post('search', [TimeRecordingSystemScheduleWorkTimeRecordingCheckCurrentPaydayController::class, 'search'])->name('groups.time-recording-system.schedulework.time-recording-check-current-payday.search');
                    Route::post('view-user', [TimeRecordingSystemScheduleWorkTimeRecordingCheckCurrentPaydayController::class, 'viewUser'])->name('groups.time-recording-system.schedulework.time-recording-check-current-payday.view-user');
                    Route::post('update', [TimeRecordingSystemScheduleWorkTimeRecordingCheckCurrentPaydayController::class, 'update'])->name('groups.time-recording-system.schedulework.time-recording-check-current-payday.update');
                    Route::post('get-image', [TimeRecordingSystemScheduleWorkTimeRecordingCheckCurrentPaydayController::class, 'getImage'])->name('groups.time-recording-system.schedulework.time-recording-check-current-payday.get-image');
                    Route::post('upload-image', [TimeRecordingSystemScheduleWorkTimeRecordingCheckCurrentPaydayController::class, 'uploadImage'])->name('groups.time-recording-system.schedulework.time-recording-check-current-payday.upload-image');
                    Route::post('delete-image', [TimeRecordingSystemScheduleWorkTimeRecordingCheckCurrentPaydayController::class, 'deleteImage'])->name('groups.time-recording-system.schedulework.time-recording-check-current-payday.delete-image');
                    Route::post('get-leave-attachment', [TimeRecordingSystemScheduleWorkTimeRecordingCheckCurrentPaydayController::class, 'getLeaveAttachment'])->name('groups.time-recording-system.schedulework.time-recording-check-current-payday.get-leave-attachment');
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
        Route::group(['prefix' => 'assessment-system'], function () {
            Route::group(['prefix' => 'assessment'], function () {
                Route::group(['prefix' => 'assessment'], function () {
                    Route::get('', [AssessmentSystemAssessmentController::class, 'index'])->name('groups.assessment-system.assessment.assessment');
                    Route::get('create', [AssessmentSystemAssessmentController::class, 'create'])->name('groups.assessment-system.assessment.assessment.create');
                    Route::post('store', [AssessmentSystemAssessmentController::class, 'store'])->name('groups.assessment-system.assessment.assessment.store');
                    Route::group(['prefix' => 'assignment'], function () {
                        Route::get('{id}', [AssessmentSystemAssessmentAssignmentController::class, 'index'])->name('groups.assessment-system.assessment.assessment.assignment');
                        Route::post('import-user', [AssessmentSystemAssessmentAssignmentController::class, 'importUser'])->name('groups.assessment-system.assessment.assessment.assignment.import-user');
                        Route::group(['prefix' => 'scoring'], function () {
                            Route::get('{user_id}/{id}', [AssessmentSystemAssessmentAssignmentScoringController::class, 'index'])->name('groups.assessment-system.assessment.assessment.assignment.scoring');
                        });
                    });
                });
            });
            Route::group(['prefix' => 'setting'], function () {
                Route::group(['prefix' => 'assessment-group'], function () {
                    Route::get('', [AssessmentSystemSettingAssessmentGroupController::class, 'index'])->name('groups.assessment-system.setting.assessment-group');
                    Route::get('create', [AssessmentSystemSettingAssessmentGroupController::class, 'create'])->name('groups.assessment-system.setting.assessment-group.create');
                    Route::post('store', [AssessmentSystemSettingAssessmentGroupController::class, 'store'])->name('groups.assessment-system.setting.assessment-group.store');
                    Route::get('{id}', [AssessmentSystemSettingAssessmentGroupController::class, 'view'])->name('groups.assessment-system.setting.assessment-group.view');
                    Route::put('{id}', [AssessmentSystemSettingAssessmentGroupController::class, 'update'])->name('groups.assessment-system.setting.assessment-group.update');
                    Route::delete('{id}', [AssessmentSystemSettingAssessmentGroupController::class, 'delete'])->name('groups.assessment-system.setting.assessment-group.delete');
                    Route::group(['prefix' => 'assignment'], function () {
                        Route::get('{id}', [AssessmentSystemSettingAssessmentGroupAssignmentController::class, 'index'])->name('groups.assessment-system.setting.assessment-group.assignment');
                        Route::get('create/{id}', [AssessmentSystemSettingAssessmentGroupAssignmentController::class, 'create'])->name('groups.assessment-system.setting.assessment-group.assignment.create');
                        Route::post('store', [AssessmentSystemSettingAssessmentGroupAssignmentController::class, 'store'])->name('groups.assessment-system.setting.assessment-group.assignment.store');
                        Route::delete('{id}', [AssessmentSystemSettingAssessmentGroupAssignmentController::class, 'delete'])->name('groups.assessment-system.setting.assessment-group.assignment.delete');
                    });
                });
                Route::group(['prefix' => 'criteria'], function () {
                    Route::get('', [AssessmentSystemSettingCriteriaController::class, 'index'])->name('groups.assessment-system.setting.criteria');
                    Route::get('create', [AssessmentSystemSettingCriteriaController::class, 'create'])->name('groups.assessment-system.setting.criteria.create');
                    Route::post('store', [AssessmentSystemSettingCriteriaController::class, 'store'])->name('groups.assessment-system.setting.criteria.store');
                    Route::get('{id}', [AssessmentSystemSettingCriteriaController::class, 'view'])->name('groups.assessment-system.setting.criteria.view');
                    Route::put('{id}', [AssessmentSystemSettingCriteriaController::class, 'update'])->name('groups.assessment-system.setting.criteria.update');
                    Route::delete('{id}', [AssessmentSystemSettingCriteriaController::class, 'delete'])->name('groups.assessment-system.setting.criteria.delete');
                });
                Route::group(['prefix' => 'score'], function () {
                    Route::get('', [AssessmentSystemSettingScoreController::class, 'index'])->name('groups.assessment-system.setting.score');
                    Route::get('create', [AssessmentSystemSettingScoreController::class, 'create'])->name('groups.assessment-system.setting.score.create');
                    Route::post('store', [AssessmentSystemSettingScoreController::class, 'store'])->name('groups.assessment-system.setting.score.store');
                    Route::get('{id}', [AssessmentSystemSettingScoreController::class, 'view'])->name('groups.assessment-system.setting.score.view');
                    Route::put('{id}', [AssessmentSystemSettingScoreController::class, 'update'])->name('groups.assessment-system.setting.score.update');
                    Route::delete('{id}', [AssessmentSystemSettingScoreController::class, 'delete'])->name('groups.assessment-system.setting.score.delete');
                });
                Route::group(['prefix' => 'multiplication'], function () {
                    Route::get('', [AssessmentSystemSettingMultiplicationController::class, 'index'])->name('groups.assessment-system.setting.multiplication');
                    Route::get('create', [AssessmentSystemSettingMultiplicationController::class, 'create'])->name('groups.assessment-system.setting.multiplication.create');
                    Route::post('store', [AssessmentSystemSettingMultiplicationController::class, 'store'])->name('groups.assessment-system.setting.multiplication.store');
                    Route::get('{id}', [AssessmentSystemSettingMultiplicationController::class, 'view'])->name('groups.assessment-system.setting.multiplication.view');
                    Route::put('{id}', [AssessmentSystemSettingMultiplicationController::class, 'update'])->name('groups.assessment-system.setting.multiplication.update');
                    Route::delete('{id}', [AssessmentSystemSettingMultiplicationController::class, 'delete'])->name('groups.assessment-system.setting.multiplication.delete');
                });
            });
        });
        Route::group(['prefix' => 'announcement-system'], function () {
            Route::group(['prefix' => 'setting'], function () {
                Route::group(['prefix' => 'category'], function () {
                    Route::get('', [AnnounceSystemSettingCategoryController::class, 'index'])->name('groups.announcement-system.setting.category');
                });
            });
        });
        Route::group(['prefix' => 'job-application-system'], function () {
            Route::group(['prefix' => 'setting'], function () {
                Route::group(['prefix' => 'category'], function () {
                    Route::get('', [JobApplicationSystemSettingCategoryController::class, 'index'])->name('groups.job-application-system.setting.category');
                });
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
                    Route::group(['prefix' => 'assignment'], function () {
                        Route::get('{id}', [SalarySystemSettingPaydayAssignmentController::class, 'index'])->name('groups.salary-system.setting.payday.assignment');
                        Route::post('store', [SalarySystemSettingPaydayAssignmentController::class, 'store'])->name('groups.salary-system.setting.payday.assignment.store');
                        Route::delete('{id}', [SalarySystemSettingPaydayAssignmentController::class, 'delete'])->name('groups.salary-system.setting.payday.assignment.delete');
                        Route::post('view', [SalarySystemSettingPaydayAssignmentController::class, 'view'])->name('groups.salary-system.setting.payday.assignment.view');
                        Route::post('update', [SalarySystemSettingPaydayAssignmentController::class, 'update'])->name('groups.salary-system.setting.payday.assignment.update');
                    });
                    Route::group(['prefix' => 'assignment-user'], function () {
                        Route::get('{id}', [SalarySystemSettingPaydayAssignmentUserController::class, 'index'])->name('groups.salary-system.setting.payday.assignment-user');
                        Route::get('create/{id}', [SalarySystemSettingPaydayAssignmentUserController::class, 'create'])->name('groups.salary-system.setting.payday.assignment-user.create');
                        Route::post('store', [SalarySystemSettingPaydayAssignmentUserController::class, 'store'])->name('groups.salary-system.setting.payday.assignment-user.store');
                        Route::post('import-employee-no', [SalarySystemSettingPaydayAssignmentUserController::class, 'importEmployeeNo'])->name('groups.salary-system.setting.payday.assignment-user.import-employee-no');
                        Route::delete('paydays/{payday_id}/users/{user_id}', [SalarySystemSettingPaydayAssignmentUserController::class, 'delete'])->name('groups.salary-system.setting.payday.assignment-user.delete');
                    });
                });
                Route::group(['prefix' => 'skill-based-cost'], function () {
                    Route::get('', [SalarySystemSettingSkillBasedCostController::class, 'index'])->name('groups.salary-system.setting.skill-based-cost');
                    Route::get('create', [SalarySystemSettingSkillBasedCostController::class, 'create'])->name('groups.salary-system.setting.skill-based-cost.create');
                    Route::post('store', [SalarySystemSettingSkillBasedCostController::class, 'store'])->name('groups.salary-system.setting.skill-based-cost.store');
                    Route::get('{id}', [SalarySystemSettingSkillBasedCostController::class, 'view'])->name('groups.salary-system.setting.skill-based-cost.view');
                    Route::put('{id}', [SalarySystemSettingSkillBasedCostController::class, 'update'])->name('groups.salary-system.setting.skill-based-cost.update');
                    Route::delete('{id}', [SalarySystemSettingSkillBasedCostController::class, 'delete'])->name('groups.salary-system.setting.skill-based-cost.delete');
                });
                Route::group(['prefix' => 'income-deduct'], function () {
                    Route::get('', [SalarySystemSettingIncomeDuctController::class, 'index'])->name('groups.salary-system.setting.income-deduct');
                });
                Route::group(['prefix' => 'diligence-allowance'], function () {
                    Route::get('', [SalarySystemSettingDiligenceAllowanceController::class, 'index'])->name('groups.salary-system.setting.diligence-allowance');
                    Route::get('create', [SalarySystemSettingDiligenceAllowanceController::class, 'create'])->name('groups.salary-system.salary.diligence-allowance.create');
                    Route::post('store', [SalarySystemSettingDiligenceAllowanceController::class, 'store'])->name('groups.salary-system.salary.diligence-allowance.store');
                    Route::get('{id}', [SalarySystemSettingDiligenceAllowanceController::class, 'view'])->name('groups.salary-system.salary.diligence-allowance.view');
                    Route::put('{id}', [SalarySystemSettingDiligenceAllowanceController::class, 'update'])->name('groups.salary-system.salary.diligence-allowance.update');
                    Route::delete('{id}', [SalarySystemSettingDiligenceAllowanceController::class, 'delete'])->name('groups.salary-system.salary.diligence-allowance.delete');
                    Route::group(['prefix' => 'assignment'], function () {
                        Route::get('{id}', [SalarySystemSettingDiligenceAllowanceAssignmentController::class, 'index'])->name('groups.salary-system.setting.diligence-allowance.assignment');
                        Route::get('create/{id}', [SalarySystemSettingDiligenceAllowanceAssignmentController::class, 'create'])->name('groups.salary-system.setting.diligence-allowance.assignment.create');
                        Route::post('store', [SalarySystemSettingDiligenceAllowanceAssignmentController::class, 'store'])->name('groups.salary-system.setting.diligence-allowance.assignment.store');
                    });
                });
            });
            Route::group(['prefix' => 'salary'], function () {
                Route::group(['prefix' => 'calculation-list'], function () {
                    Route::get('', [SalarySystemSalaryCalculationListController::class, 'index'])->name('groups.salary-system.salary.calculation-list');
                    Route::group(['prefix' => 'calculation'], function () {
                        Route::get('{id}', [SalarySystemSalaryCalculationListCalculationController::class, 'index'])->name('groups.salary-system.salary.calculation-list.calculation');
                        Route::post('import-income-deduct', [SalarySystemSalaryCalculationListCalculationController::class, 'importIncomeDeduct'])->name('groups.salary-system.salary.calculation-list.calculation.import-income-deduct');
                        Route::group(['prefix' => 'information'], function () {
                            Route::get('{start_date}/{end_date}/{user_id}/{payday_detail_id}', [SalarySystemSalaryCalculationExtraListCalculationInformationController::class, 'index'])->name('groups.salary-system.salary.calculation-extra-list.calculation.information');
                        });
                    });
                    Route::group(['prefix' => 'summary'], function () {
                        Route::get('{id}', [SalarySystemSalaryCalculationListSummaryController::class, 'index'])->name('groups.salary-system.salary.calculation-list.summary');
                        
                    });
                });
                
                Route::group(['prefix' => 'calculation-extra-list'], function () {
                    Route::get('', [SalarySystemSalaryCalculationExtraListController::class, 'index'])->name('groups.salary-system.salary.calculation-extra-list');
                    Route::group(['prefix' => 'calculation'], function () {
                        Route::get('{id}', [SalarySystemSalaryCalculationExtraListCalculationController::class, 'index'])->name('groups.salary-system.salary.calculation-extra-list.calculation');
                    });
                    Route::group(['prefix' => 'summary'], function () {
                        Route::get('{id}', [SalarySystemSalaryCalculationExtraListSummaryController::class, 'index'])->name('groups.salary-system.salary.calculation-extra-list.summary');
                    });
                });
                
                Route::group(['prefix' => 'calculation'], function () {
                    Route::get('', [SalarySystemSalaryCalculationController::class, 'index'])->name('groups.salary-system.salary.calculation');
                    Route::get('create', [SalarySystemSalaryCalculationController::class, 'create'])->name('groups.salary-system.salary.calculation.create');
                    Route::post('store', [SalarySystemSalaryCalculationController::class, 'store'])->name('groups.salary-system.salary.calculation.store');
                    Route::get('{id}', [SalarySystemSalaryCalculationController::class, 'view'])->name('groups.salary-system.salary.calculation.view');
                    Route::put('{id}', [SalarySystemSalaryCalculationController::class, 'update'])->name('groups.salary-system.salary.calculation.update');
                    Route::delete('{id}', [SalarySystemSalaryCalculationController::class, 'delete'])->name('groups.salary-system.salary.calculation.delete');
                    Route::post('search', [SalarySystemSalaryCalculationController::class, 'search'])->name('groups.salary-system.salary.calculation.search');
                    Route::group(['prefix' => 'information'], function () {
                        Route::get('{start_date}/{end_date}/{user_id}', [SalarySystemSalaryCalculationInformationController::class, 'index'])->name('groups.salary-system.salary.calculation.information');
                    });
                });
                Route::group(['prefix' => 'income-deduct-assignment'], function () {
                    Route::get('', [SalarySystemSalaryIncomeDeductAssignmentController::class, 'index'])->name('groups.salary-system.salary.income-deduct-assignment');
                    Route::post('store', [SalarySystemSalaryIncomeDeductAssignmentController::class, 'store'])->name('groups.salary-system.salary.income-deduct-assignment.store');
                    Route::post('delete', [SalarySystemSalaryIncomeDeductAssignmentController::class, 'delete'])->name('groups.salary-system.salary.income-deduct-assignment.delete');
                    Route::post('search', [SalarySystemSalaryIncomeDeductAssignmentController::class, 'search'])->name('groups.salary-system.salary.income-deduct-assignment.search');
                });
                Route::group(['prefix' => 'summary'], function () {
                    Route::get('', [SalarySystemSalarySummaryController::class, 'index'])->name('groups.salary-system.salary.summary');
                    
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
                    Route::post('get-users', [DocumentSystemSettingApproveDocumentController::class, 'getUsers'])->name('groups.document-system.setting.approve-document.get-users');

                    Route::group(['prefix' => 'assignment'], function () {
                        Route::get('{id}', [DocumentSystemSettingApproveDocumentAssignmentController::class, 'index'])->name('groups.document-system.setting.approve-document.assignment.index');
                        Route::get('create/{id}', [DocumentSystemSettingApproveDocumentAssignmentController::class, 'create'])->name('groups.document-system.setting.approve-document.assignment.create');
                        Route::post('store', [DocumentSystemSettingApproveDocumentAssignmentController::class, 'store'])->name('groups.document-system.setting.approve-document.assignment.store');
                        Route::delete('approves/{approver_id}/users/{user_id}/delete', [DocumentSystemSettingApproveDocumentAssignmentController::class, 'delete'])->name('groups.document-system.setting.approve-document.assignment.delete');
                        Route::post('search', [DocumentSystemSettingApproveDocumentAssignmentController::class, 'search'])->name('groups.document-system.setting.approve-document.assignment.search');
                        Route::post('import-employee-no', [DocumentSystemSettingApproveDocumentAssignmentController::class, 'importEmployeeNo'])->name('groups.document-system.setting.approve-document.assignment.import-employee-no');
                    });
                });
            });
            Route::group(['prefix' => 'leave'], function () {
                Route::group(['prefix' => 'document'], function () {
                    Route::get('', [DocumentSystemLeaveDocumentController::class, 'index'])->name('groups.document-system.leave.document');
                    Route::get('create', [DocumentSystemLeaveDocumentController::class, 'create'])->name('groups.document-system.leave.document.create');
                    Route::post('check-leave', [DocumentSystemLeaveDocumentController::class, 'checkLeave'])->name('groups.document-system.leave.document.check-leave');
                    Route::post('store', [DocumentSystemLeaveDocumentController::class, 'store'])->name('groups.document-system.leave.document.store');
                    Route::get('{id}', [DocumentSystemLeaveDocumentController::class, 'view'])->name('groups.document-system.leave.document.view');
                    // Route::post('{id}', [DocumentSystemLeaveDocumentController::class, 'update'])->name('groups.document-system.leave.document.update');
                    Route::delete('{id}', [DocumentSystemLeaveDocumentController::class, 'delete'])->name('groups.document-system.leave.document.delete');
                    Route::post('search', [DocumentSystemLeaveDocumentController::class, 'search'])->name('groups.document-system.leave.document.search');
                    Route::post('get-attachment', [DocumentSystemLeaveDocumentController::class, 'getAttachment'])->name('groups.document-system.leave.document.get-attachment');
                    
                });
                Route::group(['prefix' => 'approval'], function () {
                    Route::get('', [DocumentSystemLeaveApprovalController::class, 'index'])->name('groups.document-system.leave.approval');
                    Route::post('leave-approval', [DocumentSystemLeaveApprovalController::class, 'leaveApproval'])->name('groups.document-system.leave.approval.leave-approval');
                    Route::post('search', [DocumentSystemLeaveApprovalController::class, 'search'])->name('groups.document-system.leave.approval.search');

                });
            });
              Route::group(['prefix' => 'overtime'], function () {
                Route::group(['prefix' => 'document'], function () {
                    Route::get('', [DocumentSystemOvertimeDocumentController::class, 'index'])->name('groups.document-system.overtime.document');
                    Route::get('create', [DocumentSystemOvertimeDocumentController::class, 'create'])->name('groups.document-system.overtime.document.create');
                    Route::post('store', [DocumentSystemOvertimeDocumentController::class, 'store'])->name('groups.document-system.overtime.document.store');
                    Route::get('{id}', [DocumentSystemOvertimeDocumentController::class, 'view'])->name('groups.document-system.overtime.document.view');
                    Route::put('{id}', [DocumentSystemOvertimeDocumentController::class, 'update'])->name('groups.document-system.overtime.document.update');
                    Route::delete('{id}', [DocumentSystemOvertimeDocumentController::class, 'delete'])->name('groups.document-system.overtime.document.delete');
                    Route::post('get-users', [DocumentSystemOvertimeDocumentController::class, 'getUsers'])->name('groups.document-system.overtime.document.get-users');
                    Route::group(['prefix' => 'assignment'], function () {
                        Route::get('{id}', [DocumentSystemOvertimeApprovalAssignmentController::class, 'index'])->name('groups.document-system.overtime.approval.assignment');
                        Route::get('create/{id}', [DocumentSystemOvertimeApprovalAssignmentController::class, 'create'])->name('groups.document-system.overtime.approval.assignment.create');
                        Route::post('store', [DocumentSystemOvertimeApprovalAssignmentController::class, 'store'])->name('groups.document-system.overtime.approval.assignment.store');
                        Route::delete('overtimes/{overtime_id}/users/{user_id}/delete', [DocumentSystemOvertimeApprovalAssignmentController::class, 'delete'])->name('groups.document-system.overtime.approval.assignment.delete');
                        Route::post('search', [DocumentSystemOvertimeApprovalAssignmentController::class, 'search'])->name('groups.document-system.overtime.approval.assignment.search');
                        Route::post('import-user-group', [DocumentSystemOvertimeApprovalAssignmentController::class, 'importUserGroup'])->name('groups.document-system.overtime.approval.assignment.import-user-group');        
                        Route::post('import-employee-no', [DocumentSystemOvertimeApprovalAssignmentController::class, 'importEmployeeNo'])->name('groups.document-system.overtime.approval.assignment.import-employee-no');        
                    });
                });
                Route::group(['prefix' => 'approval'], function () {
                    Route::get('', [DocumentSystemOvertimeApprovalController::class, 'index'])->name('groups.document-system.overtime.approval');
                    Route::post('overtime-approval', [DocumentSystemOvertimeApprovalController::class, 'overtimeApproval'])->name('groups.document-system.overtime.approval.overtime-approval');
                    Route::post('search', [DocumentSystemOvertimeApprovalController::class, 'search'])->name('groups.document-system.overtime.approval.search');
                });
            });
        });
        Route::group(['prefix' => 'user-management-system'], function () {
            Route::group(['prefix' => 'setting'], function () {
                Route::group(['prefix' => 'userinfo'], function () {
                    Route::get('', [UserManagementSystemSettingUserInfoController::class, 'index'])->name('groups.user-management-system.setting.userinfo');
                    Route::get('{id}', [UserManagementSystemSettingUserInfoController::class, 'view'])->name('groups.user-management-system.setting.userinfo.view');
                    Route::post('search', [UserManagementSystemSettingUserInfoController::class, 'search'])->name('groups.user-management-system.setting.userinfo.search');
                    Route::group(['prefix' => 'salary'], function () {
                        Route::post('store', [UserManagementSystemSettingUserInfoSalaryController::class, 'store'])->name('groups.user-management-system.setting.userinfo.salary.store');
                        Route::post('get-salary', [UserManagementSystemSettingUserInfoSalaryController::class, 'getSalary'])->name('groups.user-management-system.setting.userinfo.get-salary');
                        Route::post('update', [UserManagementSystemSettingUserInfoSalaryController::class, 'update'])->name('groups.user-management-system.setting.userinfo.salary.update');
                        Route::post('delete', [UserManagementSystemSettingUserInfoSalaryController::class, 'delete'])->name('groups.user-management-system.setting.userinfo.salary.delete');
                    });
                    Route::group(['prefix' => 'workschedule'], function () {
                        Route::post('update-workschedule', [UserManagementSystemSettingUserInfoWorkscheduleController::class, 'updateWorkschedule'])->name('groups.user-management-system.setting.userinfo.workschedule.update-workschedule');
                        Route::post('update-payday', [UserManagementSystemSettingUserInfoWorkscheduleController::class, 'updatePayday'])->name('groups.user-management-system.setting.userinfo.workschedule.update-payday');
                        Route::post('update-approver', [UserManagementSystemSettingUserInfoWorkscheduleController::class, 'updateApprover'])->name('groups.user-management-system.setting.userinfo.workschedule.update-approver');
                        Route::post('get-approver', [UserManagementSystemSettingUserInfoWorkscheduleController::class, 'getApprover'])->name('groups.user-management-system.setting.userinfo.workschedule.get-approver');
                    });
                    Route::group(['prefix' => 'position'], function () {
                        Route::post('store', [UserManagementSystemSettingUserInfoPositionController::class, 'store'])->name('groups.user-management-system.setting.userinfo.position.store');
                        Route::post('get-position', [UserManagementSystemSettingUserInfoPositionController::class, 'getPosition'])->name('groups.user-management-system.setting.userinfo.position.get-position');
                        Route::post('update-position', [UserManagementSystemSettingUserInfoPositionController::class, 'updatePosition'])->name('groups.user-management-system.setting.userinfo.position.update-position');
                        Route::post('delete', [UserManagementSystemSettingUserInfoPositionController::class, 'delete'])->name('groups.user-management-system.setting.userinfo.position.delete');
                    });
                    Route::group(['prefix' => 'education'], function () {
                        Route::post('store', [UserManagementSystemSettingUserInfoEducationController::class, 'store'])->name('groups.user-management-system.setting.userinfo.education.store');
                        Route::post('get-education', [UserManagementSystemSettingUserInfoEducationController::class, 'getEducation'])->name('groups.user-management-system.setting.userinfo.education.get-education');
                        Route::post('update-education', [UserManagementSystemSettingUserInfoEducationController::class, 'updateEducation'])->name('groups.user-management-system.setting.userinfo.education.update-education');
                        Route::post('delete', [UserManagementSystemSettingUserInfoEducationController::class, 'delete'])->name('groups.user-management-system.setting.userinfo.education.delete');
                    });
                    Route::group(['prefix' => 'training'], function () {
                        Route::post('store', [UserManagementSystemSettingUserInfoTrainingController::class, 'store'])->name('groups.user-management-system.setting.userinfo.training.store');
                        Route::post('get-training', [UserManagementSystemSettingUserInfoTrainingController::class, 'getTraining'])->name('groups.user-management-system.setting.userinfo.training.get-training');
                        Route::post('update-training', [UserManagementSystemSettingUserInfoTrainingController::class, 'updateTraining'])->name('groups.user-management-system.setting.userinfo.training.update-training');
                        Route::post('delete', [UserManagementSystemSettingUserInfoTrainingController::class, 'delete'])->name('groups.user-management-system.setting.userinfo.training.delete');
                    });
                    Route::group(['prefix' => 'punishment'], function () {
                        Route::post('store', [UserManagementSystemSettingUserInfoPunishmentController::class, 'store'])->name('groups.user-management-system.setting.userinfo.punishment.store');
                        Route::post('get-punishment', [UserManagementSystemSettingUserInfoPunishmentController::class, 'getPunishment'])->name('groups.user-management-system.setting.userinfo.punishment.get-punishment');
                        Route::post('update-punishment', [UserManagementSystemSettingUserInfoPunishmentController::class, 'updatePunishment'])->name('groups.user-management-system.setting.userinfo.punishment.update-punishment');
                        Route::post('delete', [UserManagementSystemSettingUserInfoPunishmentController::class, 'delete'])->name('groups.user-management-system.setting.userinfo.punishment.delete');
                    });
                    Route::group(['prefix' => 'attachment'], function () {
                        Route::post('store', [UserManagementSystemSettingUserInfAttachmentController::class, 'store'])->name('groups.user-management-system.setting.userinfo.attachment.store');
                        Route::post('delete', [UserManagementSystemSettingUserInfAttachmentController::class, 'delete'])->name('groups.user-management-system.setting.userinfo.attachment.delete');
                    });
                    Route::group(['prefix' => 'diligence-allowance-classify'], function () {
                        Route::post('get-diligence-allowance-classify', [UserManagementSystemSettingUserInfDiligenceAllowanceClassifyController::class, 'getDiligenceAllowanceClassify'])->name('groups.user-management-system.setting.userinfo.get-diligence-allowance-classify');
                        Route::post('update-diligence-allowance-classify', [UserManagementSystemSettingUserInfDiligenceAllowanceClassifyController::class, 'updateDiligenceAllowanceClassify'])->name('groups.user-management-system.setting.userinfo.update-diligence-allowance-classify');
                    });
                });
                Route::group(['prefix' => 'userleave'], function () {
                    Route::get('', [UserManagementSystemSettingUserLeaveController::class, 'index'])->name('groups.user-management-system.setting.userleave');
                    
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
            Route::group(['prefix' => 'company'], function () {
                Route::get('', [SettingOrganizationCompanyController::class, 'index'])->name('setting.organization.company.index');
                Route::put('{id}', [SettingOrganizationCompanyController::class, 'update'])->name('setting.organization.company.update');
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

