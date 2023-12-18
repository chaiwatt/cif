@extends('layouts.setting-dashboard')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{$user->name}} {{$user->lastname}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">พนักงาน</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">รายละเอียดข้อมูลพนักงาน</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('setting.organization.employee.update', ['id' => $user->id]) }}"
                                method="POST">
                                @method('PUT')
                                @csrf
                                <!-- Display validation errors -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>รหัสพนักงาน<span class="small text-danger">*</span></label>
                                            <input type="text" name="employee_no"
                                                value="{{old('employee_no') ?? $user->employee_no}}"
                                                class="form-control numericInputInt @error('employee_no') is-invalid @enderror"
                                                readonly>
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
                                            <div class="input-group date" id="birth_date" data-target-input="nearest">
                                                <input name="birthDate"
                                                    value="{{old('birthDate') ?? $user->birth_date}}" type="text"
                                                    class="form-control datetimepicker-input" data-target="#birth_date">
                                                <div class="input-group-append" data-target="#birth_date"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
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
                                                <option value="{{ $companyDepartment->id }}" @if ($companyDepartment->id
                                                    ==
                                                    $user->company_department_id) selected @endif>
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
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>พาสพอร์ต</label>
                                                <input type="text" name="passport"
                                                    value="{{old('passport') ?? $user->passport}}" class="form-control">
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
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
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
                                                <div class="input-group-append" data-target="#work_permit_expire_date"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
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
                                            <label>เลขที่ประกันสังคม</label>
                                            <input type="text" name="social_security_number"
                                                value="{{old('social_security_number') ?? $user->social_security_number}}"
                                                class="form-control numericInputInt">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>การสแกนเวลาเข้าออก<span class="small text-danger">*</span></label>
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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>รหัสผ่านใหม่ (เว้นว่างถ้าไม่ต้องการเปลี่ยน)</label>
                                            <input type="text" name="password" value="" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit"
                                            class="btn bg-gradient-success btn-flat float-right">บันทึก</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    $(function () {
        $('.select2').select2()
        //Date picker
        $('#birth_date,#start_work_date,#visa_expire_date,#work_permit_expire_date').datetimepicker({
            format: 'L'
        });
    });
</script>
@endpush
@endsection