@extends('layouts.setting-dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">เพิ่มพนักงาน</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">เพิ่มพนักงาน</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 rounded-4">
                        <div class="py-3 px-4">
                            <h3 class="m-0">รายละเอียดข้อมูลพนักงาน</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('setting.organization.employee.store')}}" method="POST">
                                @csrf
                                <!-- Display validation errors -->
                                <div class="row gy-2">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>รหัสพนักงาน<span class="small text-danger">*</span></label>
                                            <input type="text" name="employee_no" value="{{old('employee_no')}}"
                                                class="form-control numericInputInt @error('employee_no') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>คำนำหน้าชื่อ<span class="small text-danger">*</span></label>
                                            <select name="prefix"
                                                class="form-control select2 @error('prefix') is-invalid @enderror"
                                                style="width: 100%;">
                                                @foreach ($prefixes as $prefix)
                                                <option value="{{ $prefix->id }}" {{ old('prefix')==$prefix->id ?
                                                    'selected' : '' }}>
                                                    {{ $prefix->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>ชื่อ<span class="small text-danger">*</span></label>
                                            <input type="text" name="name" value="{{old('name')}}"
                                                class="form-control @error('name') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>นามสกุล<span class="small text-danger">*</span></label>
                                            <input type="text" name="lastname" value="{{old('lastname')}}"
                                                class="form-control @error('lastname') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>เลขที่บัตรประชาชน</label>
                                            <input type="text" name="hid" value="{{old('hid')}}"
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
                                                <option value="{{ $nationality->id }}" {{
                                                    old('nationality')==$nationality->id ?
                                                    'selected' : '' }}>
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
                                                <option value="{{ $ethnicity->id }}" {{ old('ethnicity')==$ethnicity->id
                                                    ?
                                                    'selected' : '' }}>
                                                    {{ $ethnicity->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>วันเดือนปี เกิด</label>
                                            <div class="date-box date" id="birth_date" data-target-input="nearest">
                                                <input name="birthDate" value="{{old('birthDate')}}" type="text"
                                                    class="form-control datetimepicker-input" data-target="#birth_date">
                                                <div class="date-icon" data-target="#birth_date"
                                                    data-toggle="datetimepicker">
                                                    <span class="material-symbols-outlined">
                                                        today
                                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>ที่อยู่<span class="small text-danger">*</span></label>
                                            <input type="text" name="address" value="{{old('address')}}"
                                                class="form-control @error('address') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>เบอร์โทรศัพท์มือถือ</label>
                                            <input type="text" name="phone" value="{{old('phone')}}"
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
                                                <option value="{{ $employeeType->id }}" {{
                                                    old('employeeType')==$employeeType->id
                                                    ?
                                                    'selected' : '' }}>
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
                                                <option value="{{ $userPosition->id }}" {{
                                                    old('userPosition')==$userPosition->id
                                                    ?
                                                    'selected' : '' }}>
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
                                                <option value="{{ $companyDepartment->id }}" {{
                                                    old('companyDepartment')==$companyDepartment->id
                                                    ?
                                                    'selected' : '' }}>
                                                    {{ $companyDepartment->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>เริ่มทำงาน<span class="small text-danger">*</span></label>
                                            <div class="date-box date" id="start_work_date"
                                                data-target-input="nearest">
                                                <input name="startWorkDate" value="{{old('startWorkDate')}}" type="text"
                                                    class="form-control datetimepicker-input @error('startWorkDate') is-invalid @enderror"
                                                    data-target="#start_work_date">
                                                <div class="date-icon" data-target="#start_work_date"
                                                    data-toggle="datetimepicker">
                                                    <span class="material-symbols-outlined">
                                                        today
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>พาสพอร์ต</label>
                                                <input type="text" name="passport" value="{{old('passport')}}"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>วันหมดอายุวีซ่า</label>
                                            <div class="date-box date" id="visa_expire_date"
                                                data-target-input="nearest">
                                                <input name="visaExpireDate" value="{{old('visaExpireDate')}}"
                                                    type="text"
                                                    class="form-control datetimepicker-input @error('visaExpireDate') is-invalid @enderror"
                                                    data-target="#visa_expire_date">
                                                <div class="date-icon" data-target="#visa_expire_date"
                                                    data-toggle="datetimepicker">
                                                    <span class="material-symbols-outlined">
                                                        today
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>เลขที่ใบอนุญาตทำงาน</label>
                                                <input type="text" name="work_permit" value="{{old('work_permit')}}"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>วันหมดอายุใบอนุญาตทำงาน</label>
                                            <div class="date-box date" id="work_permit_expire_date"
                                                data-target-input="nearest">
                                                <input type="text" name="workPermitExpireDate"
                                                    value="{{old('workPermitExpireDate')}}"
                                                    class="form-control datetimepicker-input @error('workPermitExpireDate') is-invalid @enderror"
                                                    data-target="#work_permit_expire_date">
                                                <div class="date-icon" data-target="#work_permit_expire_date"
                                                    data-toggle="datetimepicker">
                                                    <span class="material-symbols-outlined">
                                                        today
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>เลขที่บัญชี</label>
                                                <input type="text" name="bank" value="{{old('bank')}}"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>เลขที่บัญชี</label>
                                            <input type="text" name="bankAccount" value="{{old('bankAccount')}}"
                                                class="form-control numericInputInt">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>เลขประจำตัวผู้เสียภาษีอากร</label>
                                            <input type="text" name="tax" value="{{old('tax')}}"
                                                class="form-control numericInputInt">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>เลขที่ประกันสังคม</label>
                                            <input type="text" name="social_security_number"
                                                value="{{old('social_security_number')}}"
                                                class="form-control numericInputInt">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>การสแกนเวลาเข้าออก<span class="small text-danger">*</span></label>
                                            <select name="timeRecordRequire"
                                                class="form-control select2 @error('timeRecordRequire') is-invalid @enderror"
                                                style="width: 100%;">

                                                <option value="1">
                                                    ต้องสแกนเวลา
                                                </option>
                                                <option value="0">
                                                    ไม่ต้องสแกนเวลา
                                                </option>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-12 text-end">
                                        <button type="submit"
                                            class="btn btn-primary">บันทึก</button>
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
        $('#birth_date,#start_work_date,#visa_expire_date,#work_permit_expire_date').datetimepicker({
            format: 'L'
        });
    });

</script>
@endpush
@endsection