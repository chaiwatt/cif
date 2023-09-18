@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{$user->name}} {{$user->lastname}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">{{$user->name}} {{$user->lastname}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($permission->show)
            <div class="row">
                <input type="text" id="userId" value="{{$user->id}}" hidden>
                <div class="col-12">
                    <div class="card card-info card-outline card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                                        href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                                        aria-selected="true">ข้อมูลทั่วไป</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-workschedule-tab" data-toggle="pill"
                                        href="#custom-tabs-one-workschedule" role="tab"
                                        aria-controls="custom-tabs-one-workschedule"
                                        aria-selected="false">ตารางทำงาน</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-leave-tab" data-toggle="pill"
                                        href="#custom-tabs-one-leave" role="tab" aria-controls="custom-tabs-one-leave"
                                        aria-selected="false">วันลา</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-diligence-allowance-tab" data-toggle="pill"
                                        href="#custom-tabs-one-diligence-allowance" role="tab"
                                        aria-controls="custom-tabs-one-diligence-allowance"
                                        aria-selected="false">เบี้ยขยัน</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-education-tab" data-toggle="pill"
                                        href="#custom-tabs-one-education" role="tab"
                                        aria-controls="custom-tabs-one-education" aria-selected="false">การศึกษา</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-trainings-tab" data-toggle="pill"
                                        href="#custom-tabs-one-trainings" role="tab"
                                        aria-controls="custom-tabs-one-trainings" aria-selected="false">การฝึกอบรม</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-position-adjustment-tab" data-toggle="pill"
                                        href="#custom-tabs-one-position-adjustment" role="tab"
                                        aria-controls="custom-tabs-one-position-adjustment"
                                        aria-selected="false">การปรับตำแหน่ง</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-salary-adjustment-tab" data-toggle="pill"
                                        href="#custom-tabs-one-salary-adjustment" role="tab"
                                        aria-controls="custom-tabs-one-salary-adjustment"
                                        aria-selected="false">การปรับเงินเดือน</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-punishments-tab" data-toggle="pill"
                                        href="#custom-tabs-one-punishments" role="tab"
                                        aria-controls="custom-tabs-one-punishments"
                                        aria-selected="false">ความผิดและโทษ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-documents-tab" data-toggle="pill"
                                        href="#custom-tabs-one-documents" role="tab"
                                        aria-controls="custom-tabs-one-documents" aria-selected="false">เอกสารสำคัญ</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
                                    aria-labelledby="custom-tabs-one-home-tab">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>รหัสพนักงาน<span class="small text-danger">*</span></label>
                                                <input type="text" name="employee_code"
                                                    value="{{old('employee_code') ?? $user->employee_no}}"
                                                    class="form-control numericInputInt @error('employee_code') is-invalid @enderror">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>คำนำหน้าชื่อ<span class="small text-danger">*</span></label>
                                                <select name="prefix"
                                                    class="form-control select2 @error('prefix') is-invalid @enderror"
                                                    style="width: 100%;">
                                                    @foreach ($prefixes as $prefix)
                                                    <option value="{{ $prefix->id }}" @if ($prefix->id ==
                                                        $user->prefix_id) selected @endif>
                                                        {{ $prefix->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ชื่อ<span class="small text-danger">*</span></label>
                                                <input type="text" name="name" value="{{old('name') ?? $user->name}}"
                                                    class="form-control @error('name') is-invalid @enderror">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>นามสกุล<span class="small text-danger">*</span></label>
                                                <input type="text" name="lastname"
                                                    value="{{old('lastname') ?? $user->lastname}}"
                                                    class="form-control @error('lastname') is-invalid @enderror">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>เลขที่บัตรประชาชน</label>
                                                <input type="text" name="hid" value="{{old('hid') ?? $user->hid}}"
                                                    class="form-control numericInputHid">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>สัญชาติ<span class="small text-danger">*</span></label>
                                                <select name="nationality"
                                                    class="form-control select2 @error('nationality') is-invalid @enderror"
                                                    style="width: 100%;">
                                                    @foreach ($nationalities as $nationality)
                                                    <option value="{{ $nationality->id }}" @if ($nationality->id ==
                                                        $user->nationality_id) selected @endif >
                                                        {{ $nationality->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>เชื้อชาติ<span class="small text-danger">*</span></label>
                                                <select name="ethnicity"
                                                    class="form-control select2 @error('ethnicity') is-invalid @enderror"
                                                    style="width: 100%;">
                                                    @foreach ($ethnicities as $ethnicity)
                                                    <option value="{{ $ethnicity->id }}" @if ($ethnicity->id ==
                                                        $user->ethnicity_id) selected @endif>
                                                        {{ $ethnicity->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>วันเดือนปี เกิด</label>
                                                <div class="input-group date" id="birth_date"
                                                    data-target-input="nearest">
                                                    <input name="birthDate"
                                                        value="{{old('birthDate') ?? $user->birth_date}}" type="text"
                                                        class="form-control datetimepicker-input"
                                                        data-target="#birth_date">
                                                    <div class="input-group-append" data-target="#birth_date"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ที่อยู่<span class="small text-danger">*</span></label>
                                                <input type="text" name="address"
                                                    value="{{old('address') ?? $user->address}}"
                                                    class="form-control @error('address') is-invalid @enderror">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>เบอร์โทรศัพท์มือถือ</label>
                                                <input type="text" name="phone" value="{{old('phone') ?? $user->phone}}"
                                                    class="form-control numericInputPhone">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ประเภทพนักงาน<span class="small text-danger">*</span></label>
                                                <select name="employeeType"
                                                    class="form-control select2 @error('employeeType') is-invalid @enderror"
                                                    style="width: 100%;">
                                                    @foreach ($employeeTypes as $employeeType)
                                                    <option value="{{ $employeeType->id }}" @if ($employeeType->id ==
                                                        $user->employee_type_id) selected @endif>
                                                        {{ $employeeType->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ตำแหน่ง<span class="small text-danger">*</span></label>
                                                <select name="userPosition"
                                                    class="form-control select2 @error('userPosition') is-invalid @enderror"
                                                    style="width: 100%;">
                                                    @foreach ($userPositions as $userPosition)
                                                    <option value="{{ $userPosition->id }}" @if ($userPosition->id ==
                                                        $user->user_position_id) selected @endif>
                                                        {{ $userPosition->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>แผนก<span class="small text-danger">*</span></label>
                                                <select name="companyDepartment"
                                                    class="form-control select2 @error('companyDepartment') is-invalid @enderror"
                                                    style="width: 100%;">
                                                    @foreach ($companyDepartments as $companyDepartment)
                                                    <option value="{{ $companyDepartment->id }}"
                                                        @if($companyDepartment->id == $user->company_department_id)
                                                        selected @endif>
                                                        {{ $companyDepartment->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>เริ่มทำงาน<span class="small text-danger">*</span></label>
                                                <div class="input-group date" id="start_work_date"
                                                    data-target-input="nearest">
                                                    <input name="startWorkDate"
                                                        value="{{old('startWorkDate') ?? $user->start_work_date}}"
                                                        type="text"
                                                        class="form-control datetimepicker-input @error('startWorkDate') is-invalid @enderror"
                                                        data-target="#start_work_date">
                                                    <div class="input-group-append" data-target="#start_work_date"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label>พาสพอร์ต</label>
                                                    <input type="text" name="passport"
                                                        value="{{old('passport') ?? $user->passport}}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>วันหมดอายุวีซ่า</label>
                                                <div class="input-group date" id="visa_expire_date"
                                                    data-target-input="nearest">
                                                    <input name="visaExpireDate"
                                                        value="{{old('visaExpireDate') ?? $user->visa_expiry_date}}"
                                                        type="text"
                                                        class="form-control datetimepicker-input @error('visaExpireDate') is-invalid @enderror"
                                                        data-target="#visa_expire_date">
                                                    <div class="input-group-append" data-target="#visa_expire_date"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label>เลขที่ใบอนุญาตทำงาน</label>
                                                    <input type="text" name="work_permit"
                                                        value="{{old('work_permit') ?? $user->work_permit}}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>วันหมดอายุใบอนุญาตทำงาน</label>
                                                <div class="input-group date" id="work_permit_expire_date"
                                                    data-target-input="nearest">
                                                    <input type="text" name="workPermitExpireDate"
                                                        value="{{old('workPermitExpireDate') ?? $user->permit_expiry_date}}"
                                                        class="form-control datetimepicker-input @error('workPermitExpireDate') is-invalid @enderror"
                                                        data-target="#work_permit_expire_date">
                                                    <div class="input-group-append"
                                                        data-target="#work_permit_expire_date"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ธนาคาร</label>
                                                <input type="text" name="bank" value="{{old('bank') ?? $user->bank}}"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>เลขที่บัญชี</label>
                                                <input type="text" name="bankAccount"
                                                    value="{{old('bankAccount') ?? $user->bank_account}}"
                                                    class="form-control numericInputInt">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>เลขประจำตัวผู้เสียภาษีอากร</label>
                                                <input type="text" name="tax" value="{{old('tax') ?? $user->tax}}"
                                                    class="form-control numericInputInt">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>การสแกนเวลาเข้าออก<span
                                                        class="small text-danger">*</span></label>
                                                <select name="timeRecordRequire"
                                                    class="form-control select2 @error('timeRecordRequire') is-invalid @enderror"
                                                    style="width: 100%;">

                                                    <option value="1" @if ($user->time_record_require == 1) selected
                                                        @endif>
                                                        ต้องสแกนเวลา
                                                    </option>
                                                    <option value="0" @if ($user->time_record_require == 0) selected
                                                        @endif>
                                                        ไม่ต้องสแกนเวลา
                                                    </option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-workschedule" role="tabpanel"
                                    aria-labelledby="custom-tabs-one-workschedule-tab">
                                    <div class="col-12">
                                        <table class="table table-bordered table-striped dataTable dtr-inline">
                                            <thead>
                                                <tr>
                                                    <th>รายการ</th>
                                                    <th>รายละเอียด</th>
                                                    <th class="text-right">เพิ่มเติม</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <td>ตารางการทำงานปัจจุบัน</td>
                                                    <td>
                                                        <div class="form-group">
                                                            @php
                                                            $workScheduleByCurrentMonth =
                                                            $user->getWorkScheduleByCurrentMonth();
                                                            $workScheduleId = $workScheduleByCurrentMonth ?
                                                            $workScheduleByCurrentMonth->id : null;
                                                            @endphp

                                                            <select id="workScheduleId" class="form-control select2"
                                                                style="width: 100%;">
                                                                <option value="">==ไม่พบรายการ==</option>
                                                                @foreach ($workSchedules as $workSchedule)
                                                                <option value="{{ $workSchedule->id }}"
                                                                    @if($workScheduleId !==null && $workSchedule->id ==
                                                                    $workScheduleId)
                                                                    selected @endif>
                                                                    {{ $workSchedule->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">
                                                        <a class="btn btn-info btn-sm" id="update-workschedule">
                                                            <i class="fas fa-save"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>รอบคำนวนเงินเดือน</td>
                                                    <td>
                                                        <select id="payday" class="form-control select2"
                                                            style="width: 100%;" multiple>
                                                            @foreach ($paydays as $payday)
                                                            <option value="{{ $payday->id }}" {{ in_array($payday->id,
                                                                $user->paydays->pluck('id')->toArray()) ? 'selected' :
                                                                '' }}>
                                                                {{ $payday->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="text-right">
                                                        <a class="btn btn-info btn-sm" id="update-payday">
                                                            <i class="fas fa-save"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>ผู้อนุมัติล่วงเวลา</td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                @php
                                                                $selectedApproverId = null;
                                                                $matchingApprover =
                                                                $user->approvers->where('document_type_id', 2)->first();
                                                                if ($matchingApprover) {
                                                                $selectedApproverId = $matchingApprover->id;
                                                                }
                                                                @endphp

                                                                <select id="overtime-approver"
                                                                    class="form-control select2" style="width: 100%;">
                                                                    <option value="">==ไม่พบรายการ==</option>
                                                                    @foreach ($approvers->where('document_type_id', 2)
                                                                    as $approver)
                                                                    <option value="{{ $approver->id }}"
                                                                        @if($selectedApproverId !==null &&
                                                                        $selectedApproverId==$approver->id)
                                                                        selected
                                                                        @endif >
                                                                        {{ $approver->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="mt-2" for="">ผู้อนุมัติ</label>
                                                                <ul id="overtime_authorized_container">
                                                                    @foreach ($user->getAuthorizedUsers(2)
                                                                    as $authoUser)
                                                                    <li>{{$authoUser->name}} {{$authoUser->lastname}}
                                                                    </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">
                                                        <a class="btn btn-info btn-sm" id="update-overtime-approver">
                                                            <i class="fas fa-save"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>เอกสารอนุมัติการลา</td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                @php
                                                                $selectedApproverId = null;
                                                                $matchingApprover =
                                                                $user->approvers->where('document_type_id', 1)->first();
                                                                if ($matchingApprover) {
                                                                $selectedApproverId = $matchingApprover->id;
                                                                }
                                                                @endphp

                                                                <select id="leave-approver" class="form-control select2"
                                                                    style="width: 100%;">
                                                                    <option value="">==ไม่พบรายการ==</option>
                                                                    @foreach ($approvers->where('document_type_id', 1)
                                                                    as $approver)
                                                                    <option value="{{ $approver->id }}"
                                                                        @if($selectedApproverId !==null &&
                                                                        $selectedApproverId==$approver->id) selected
                                                                        @endif >
                                                                        {{ $approver->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="mt-2" for="">ผู้อนุมัติ</label>
                                                                <ul id="leave_authorized_container">
                                                                    @foreach ($user->getAuthorizedUsers(1)
                                                                    as $authoUser)
                                                                    <li>{{$authoUser->name}} {{$authoUser->lastname}}
                                                                    </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>


                                                    </td>
                                                    <td class="text-right">
                                                        <a class="btn btn-info btn-sm" id="update-leave-approver">
                                                            <i class="fas fa-save"></i>
                                                        </a>

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                <div class="tab-pane fade" id="custom-tabs-one-leave" role="tabpanel"
                                    aria-labelledby="custom-tabs-one-leave-tab">
                                    <div class="col-12" id="user-leave-container">
                                        <label for="">วันลาคงเหลือ</label>
                                        <table class="table table-bordered table-striped dataTable dtr-inline">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50%">ประเภท</th>
                                                    <th>คงเหลือ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($userLeaves as $key =>$userLeave)
                                                <tr>
                                                    <td>{{$userLeave->leaveType->name}}</td>
                                                    <td>{{$userLeave->count}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-12" id="leave-container">
                                        <label for="">รายการลา</label>
                                        <table class="table table-bordered table-striped dataTable dtr-inline">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50%">วันที่</th>
                                                    <th>ประเภท</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($leaves as $key =>$leave)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',
                                                        $leave->from_date)->format('d/m/Y H:i')
                                                        }} -
                                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',
                                                        $leave->to_date)->format('d/m/Y H:i')
                                                        }}</td>
                                                    <td>{{$leave->leaveType->name}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-diligence-allowance" role="tabpanel"
                                    aria-labelledby="custom-tabs-one-diligence-allowance-tab">
                                    {{-- เบี้ยขยัน --}}
                                    {{-- $userDiligenceAllowances --}}
                                    <div class="col-12" id="dilegence-allowance-container">
                                        <table class="table table-bordered table-striped dataTable dtr-inline">
                                            <thead>
                                                <tr>
                                                    {{-- <th>ระดับ</th> --}}
                                                    <th>รอบจ่ายเงินเดือน</th>
                                                    <th>เบี้ยขยัน</th>
                                                    <th class="text-right">เพิ่มเติม</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($userDiligenceAllowances as $key
                                                =>$userDiligenceAllowance)
                                                <tr>

                                                    {{-- <td>{{$education->level}}</td> --}}
                                                    <td>
                                                        @if ($userDiligenceAllowance->paydayDetail->start_date != null
                                                        && $userDiligenceAllowance->paydayDetail->end_date != null)
                                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d',
                                                        $userDiligenceAllowance->paydayDetail->start_date)->format('d/m/Y')
                                                        }} -
                                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d',
                                                        $userDiligenceAllowance->paydayDetail->end_date)->format('d/m/Y')
                                                        }}
                                                        @endif


                                                    </td>
                                                    <td>{{$userDiligenceAllowance->diligenceAllowanceClassify->cost}}
                                                    </td>
                                                    <td class="text-right">
                                                        @if ($loop->iteration == 2)
                                                        <a class="btn btn-info btn-sm btn-update-user-diligence-allowance"
                                                            data-id="{{$userDiligenceAllowance->id}}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        @endif

                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-education" role="tabpanel"
                                    aria-labelledby="custom-tabs-one-education-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="col-12">
                                                <a class="btn btn-primary mb-2" href="" id="btn-add-education">
                                                    <i class="fas fa-plus mr-1">
                                                    </i>
                                                    เพิ่มการศึกษา
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-12" id="education-container">
                                            <table class="table table-bordered table-striped dataTable dtr-inline">
                                                <thead>
                                                    <tr>
                                                        <th>ระดับ</th>
                                                        <th>สาขาวิชา</th>
                                                        <th>ปีที่จบ</th>
                                                        <th class="text-right">เพิ่มเติม</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($user->educations->sortBy('year') as $key =>$education)
                                                    <tr>
                                                        <td>{{$education->level}}</td>
                                                        <td>{{$education->branch}}</td>
                                                        <td>{{$education->year}}</td>
                                                        <td class="text-right">
                                                            <a class="btn btn-info btn-sm btn-update-education"
                                                                data-id="{{$education->id}}">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                            <a class="btn btn-danger btn-sm btn-delete-education"
                                                                data-id="{{$education->id}}">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-trainings" role="tabpanel"
                                    aria-labelledby="custom-tabs-one-trainings-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="col-12">
                                                <a class="btn btn-primary mb-2" href="" id="btn-add-training">
                                                    <i class="fas fa-plus mr-1">
                                                    </i>
                                                    เพิ่มการฝึกอบรม
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-12" id="training-container">
                                            <table class="table table-bordered table-striped dataTable dtr-inline">
                                                <thead>
                                                    <tr>
                                                        <th>หัวข้อ</th>
                                                        <th>หน่วยงาน</th>
                                                        <th>ปีที่ฝึกอบรม</th>
                                                        <th class="text-right">เพิ่มเติม</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($user->trainings->sortBy('year') as $key =>$training)
                                                    <tr>
                                                        <td>{{$training->course}}</td>
                                                        <td>{{$training->organizer}}</td>
                                                        <td>{{$training->year}}</td>
                                                        <td class="text-right">
                                                            <a class="btn btn-info btn-sm btn-update-training"
                                                                data-id="{{$training->id}}">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                            <a class="btn btn-danger btn-sm btn-delete-training"
                                                                data-id="{{$training->id}}">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-position-adjustment" role="tabpanel"
                                    aria-labelledby="custom-tabs-one-position-adjustment-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="col-12">
                                                <a class="btn btn-primary mb-2" href="" id="btn-add-position">
                                                    <i class="fas fa-plus mr-1">
                                                    </i>
                                                    เพิ่มตำแหน่ง
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-12" id="position-histories-container">
                                            <table class="table table-bordered table-striped dataTable dtr-inline">
                                                <thead>
                                                    <tr>
                                                        <th>วันที่ปรับ</th>
                                                        <th>ตำแหน่ง</th>
                                                        <th class="text-right">เพิ่มเติม</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($user->positionHistories->sortBy('adjust_date') as $key =>
                                                    $positionHistory)
                                                    <tr>
                                                        <td>
                                                            @if ($positionHistory->adjust_date != null)
                                                            {{
                                                            \Carbon\Carbon::createFromFormat('Y-m-d',$positionHistory->adjust_date)->format('d/m/Y')
                                                            }}
                                                            @endif
                                                        </td>
                                                        <td>{{$positionHistory->user_position->name}}</td>
                                                        <td class="text-right">
                                                            <a class="btn btn-info btn-sm btn-update-position-history"
                                                                data-id="{{$positionHistory->id}}">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                            <a class="btn btn-danger btn-sm btn-delete-position-history"
                                                                data-id="{{$positionHistory->id}}">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-salary-adjustment" role="tabpanel"
                                    aria-labelledby="custom-tabs-one-salary-adjustment-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <a class="btn btn-primary mb-2" href="" id="btn-add-salary">
                                                <i class="fas fa-plus mr-1">
                                                </i>
                                                เพิ่มเงินเดือน
                                            </a>
                                        </div>
                                        <div class="col-12" id="salary_table_container">
                                            <table class="table table-bordered table-striped dataTable dtr-inline">
                                                <thead>
                                                    <tr>
                                                        <th>วันที่ปรับ</th>
                                                        <th>เงินเดือน</th>
                                                        <th class="text-right">เพิ่มเติม</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($user->salaryRecords->sortBy('record_date') as $key =>
                                                    $salaryRecord)
                                                    <tr>
                                                        <td>
                                                            @if ($salaryRecord->record_date != null)
                                                            {{ \Carbon\Carbon::createFromFormat('Y-m-d',
                                                            $salaryRecord->record_date)->format('d/m/Y') }}
                                                            @endif
                                                        </td>
                                                        <td>{{$salaryRecord->salary}}</td>
                                                        <td class="text-right">
                                                            <a class="btn btn-info btn-sm btn-update-salary"
                                                                data-id="{{$salaryRecord->id}}">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                            <a class="btn btn-danger btn-sm btn-delete-salary"
                                                                data-id="{{$salaryRecord->id}}">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-punishments" role="tabpanel"
                                    aria-labelledby="custom-tabs-one-punishments-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <a class="btn btn-primary mb-2" href="" id="btn-add-punishment">
                                                <i class="fas fa-plus mr-1">
                                                </i>
                                                เพิ่มความผิดและโทษ
                                            </a>
                                        </div>
                                        <div class="col-12" id="punishment-container">
                                            <table class="table table-bordered table-striped dataTable dtr-inline">
                                                <thead>
                                                    <tr>
                                                        <th>ความผิด / โทษ</th>
                                                        <th>วันที่บันทึก</th>
                                                        <th class="text-right">เพิ่มเติม</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($user->punishments as $key => $punishment)
                                                    <tr>
                                                        <td>
                                                            @if ($punishment->record_date != null)
                                                            {{ \Carbon\Carbon::createFromFormat('Y-m-d',
                                                            $punishment->record_date)->format('d/m/Y') }}
                                                            @endif


                                                        </td>
                                                        <td>{{$punishment->punishment}}</td>
                                                        <td class="text-right">
                                                            <a class="btn btn-info btn-sm btn-update-punishment"
                                                                data-id="{{$punishment->id}}">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                            <a class="btn btn-danger btn-sm btn-delete-punishment"
                                                                data-id="{{$punishment->id}}">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-documents" role="tabpanel"
                                    aria-labelledby="custom-tabs-one-documents-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="col-12">
                                                <a class="btn btn-primary mb-2" href="" id="btn-add-user-attachment">
                                                    <i class="fas fa-plus mr-1">
                                                    </i>
                                                    เพิ่มเอกสารสำคัญ
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-12" id="user-attachment-container">
                                            <table class="table table-bordered table-striped dataTable dtr-inline">
                                                <thead>
                                                    <tr>
                                                        <th>เอกสาร</th>
                                                        {{-- <th>ไฟล์</th> --}}
                                                        <th class="text-right">เพิ่มเติม</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($user->user_attachments as $key =>$user_attachment)
                                                    <tr>
                                                        <td>{{$user_attachment->name}}</td>
                                                        {{-- <td>{{$user_attachment->file}}</td> --}}
                                                        <td class="text-right">
                                                            <a class="btn btn-primary btn-sm"
                                                                href="{{url('/storage/uploads/attachment')}}/{{$user_attachment->file}}">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                            <a class="btn btn-danger btn-sm btn-delete-user-attachment"
                                                                data-id="{{$user_attachment->id}}">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
    <div class="modal fade" id="modal-add-salary">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>วันที่ปรับ (วดป. คศ)<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control input-date-format" id="salaray-adjustment-date">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>เงินเดือน<span class="small text-danger">*</span></label>
                                <input type="text" id="salary" class="form-control numericInputInt">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group float-right">
                                <button type="button" class="btn btn-primary" id="save-add-salary">เพิ่ม</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-update-salary">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <input type="text" id="salary-record-id" hidden>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>วันที่ปรับ (วดป. คศ)<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control input-date-format"
                                    id="update-salaray-adjustment-date">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>เงินเดือน<span class="small text-danger">*</span></label>
                                <input type="text" id="update-salary" class="form-control numericInputInt">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group float-right">
                                <button type="button" class="btn btn-primary" id="save-update-salary">แก้ไข</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-workschedule-month">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เลือกเดือน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @foreach ($months as $month)
                        <div class="col-3 mb-2 icheck-primary d-inline ">
                            <input type="checkbox" id="month_{{$month->id}}" value="">
                            <label for="month_{{$month->id}}">{{$month->name}}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" id="save-update-workschedule">แก้ไข</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-add-position">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>วันที่ปรับ (วดป. คศ)<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control input-date-format" id="position-adjustment-date">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>ตำแหน่ง<span class="small text-danger">*</span></label>
                                <select id="position" class="form-control select2" style="width: 100%;">
                                    @foreach ($userPositions as $position)
                                    <option value="{{ $position->id }}">
                                        {{ $position->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group float-right">
                                <button type="button" class="btn btn-primary" id="save-add-position">เพิ่ม</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-update-position">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row" id="update-position-modal-container">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-add-education">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>ระดับ<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control" id="education-level">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>สาขาวิชา<span class="small text-danger">*</span></label>
                                <input type="text" id="education-branch" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>ปีที่จบ<span class="small text-danger">*</span></label>
                                <input type="text" id="graduated-year" class="form-control numericInputInt">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group float-right">
                                <button type="button" class="btn btn-primary" id="save-add-education">เพิ่ม</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-update-education">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <input type="text" id="educationId" hidden>
                        <div class="col-12">
                            <div class="form-group">
                                <label>ระดับ<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control" id="update-education-level">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>สาขาวิชา<span class="small text-danger">*</span></label>
                                <input type="text" id="update-education-branch" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>ปีที่จบ<span class="small text-danger">*</span></label>
                                <input type="text" id="update-graduated-year" class="form-control numericInputInt">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group float-right">
                                <button type="button" class="btn btn-primary" id="save-update-education">แก้ไข</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-add-training">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>หัวข้อ<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control" id="training-course">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>หน่วยงาน<span class="small text-danger">*</span></label>
                                <input type="text" id="training-organizer" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>ปีที่ฝึกอบรม<span class="small text-danger">*</span></label>
                                <input type="text" id="training-year" class="form-control numericInputInt">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group float-right">
                                <button type="button" class="btn btn-primary" id="save-add-training">เพิ่ม</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-update-training">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <input type="text" id="trainingId" hidden>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>หัวข้อ<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control" id="update-training-course">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>หน่วยงาน<span class="small text-danger">*</span></label>
                                <input type="text" id="update-training-organizer" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>ปีที่ฝึกอบรม<span class="small text-danger">*</span></label>
                                <input type="text" id="update-training-year" class="form-control numericInputInt">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group float-right">
                                <button type="button" class="btn btn-primary" id="save-update-training">แก้ไข</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-add-punishment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>ความผิด / โทษ<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control" id="punishment">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>วันที่บันทึก (วดป. คศ)<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control input-date-format" id="punishment-record-date">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group float-right">
                                <button type="button" class="btn btn-primary" id="save-add-punishment">เพิ่ม</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-update-punishment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <input type="text" id="punishmentId" hidden>
                        <div class="col-12">
                            <div class="form-group">
                                <label>ความผิด / โทษ<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control" id="update-punishment">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>วันที่บันทึก (วดป. คศ)<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control input-date-format"
                                    id="update-punishment-record-date">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group float-right">
                                <button type="button" class="btn btn-primary" id="save-update-punishment">แก้ไข</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-add-attachment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>ชื่อเอกสาร<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control" id="attachment">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-info" id="btn-add-attachment">เพิ่มไฟล์แนบ <span
                                        id="attachment-file" class="text-dark"></span></button>
                                <div class="form-group">
                                    <input type="file" accept="" id="file-input" style="display: none;">
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group float-right">
                                <button type="button" class="btn btn-primary" id="save-add-attachment">เพิ่ม</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-update-user-diligence-allowance">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <input type="text" name="" id="user-diligence-allowance-id" hidden>
                    <div class="row" id="update-user-diligence-allowance-modal-container">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="module" src="{{asset('assets/js/helpers/user-management-system/setting/userinfo.js?v=1')}}"></script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    $('.select2').select2()
    window.params = {
        storeSalaryRoute: '{{ route('groups.user-management-system.setting.userinfo.salary.store') }}',
        getSalaryRoute: '{{ route('groups.user-management-system.setting.userinfo.get-salary') }}',
        updateSalaryRoute: '{{ route('groups.user-management-system.setting.userinfo.salary.update') }}',
        deleteSalaryRoute: '{{ route('groups.user-management-system.setting.userinfo.salary.delete') }}',
        updateWorkScheduleRoute: '{{ route('groups.user-management-system.setting.userinfo.workschedule.update-workschedule') }}',
        updatePaydayRoute: '{{ route('groups.user-management-system.setting.userinfo.workschedule.update-payday') }}',
        updateApproverRoute: '{{ route('groups.user-management-system.setting.userinfo.workschedule.update-approver') }}',
        getApproverRoute: '{{ route('groups.user-management-system.setting.userinfo.workschedule.get-approver') }}',
        storePositionRoute: '{{ route('groups.user-management-system.setting.userinfo.position.store') }}',
        getPositionRoute: '{{ route('groups.user-management-system.setting.userinfo.position.get-position') }}',
        updatePositionRoute: '{{ route('groups.user-management-system.setting.userinfo.position.update-position') }}',
        deletePositionRoute: '{{ route('groups.user-management-system.setting.userinfo.position.delete') }}',
        storeEducationRoute: '{{ route('groups.user-management-system.setting.userinfo.education.store') }}',
        getEducationRoute: '{{ route('groups.user-management-system.setting.userinfo.education.get-education') }}',
        updateEducationRoute: '{{ route('groups.user-management-system.setting.userinfo.education.update-education') }}',
        deleteEducationRoute: '{{ route('groups.user-management-system.setting.userinfo.education.delete') }}',
        storeTrainingRoute: '{{ route('groups.user-management-system.setting.userinfo.training.store') }}',
        getTrainingRoute: '{{ route('groups.user-management-system.setting.userinfo.training.get-training') }}',
        updateTrainingRoute: '{{ route('groups.user-management-system.setting.userinfo.training.update-training') }}',
        deleteTrainingRoute: '{{ route('groups.user-management-system.setting.userinfo.training.delete') }}',
        storePunishmentRoute: '{{ route('groups.user-management-system.setting.userinfo.punishment.store') }}',
        getPunishmentRoute: '{{ route('groups.user-management-system.setting.userinfo.punishment.get-punishment') }}',
        updatePunishmentRoute: '{{ route('groups.user-management-system.setting.userinfo.punishment.update-punishment') }}',
        deletePunishmentRoute: '{{ route('groups.user-management-system.setting.userinfo.punishment.delete') }}',

        storeAttachmentRoute: '{{ route('groups.user-management-system.setting.userinfo.attachment.store') }}',
        deleteAttachmentRoute: '{{ route('groups.user-management-system.setting.userinfo.attachment.delete') }}',

        getDiligenceAllowanceClassifyRoute: '{{ route('groups.user-management-system.setting.userinfo.get-diligence-allowance-classify') }}',
        updateDiligenceAllowanceClassifyRoute: '{{ route('groups.user-management-system.setting.userinfo.update-diligence-allowance-classify') }}',


        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection