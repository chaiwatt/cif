@extends('layouts.setting-dashboard')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger m-4">
        <ul>
            @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
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
                            <h4 class="m-0">ข้อมูลส่วนบุคคล</h4>
                        </div>
                        <form action="{{route('setting.organization.employee.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- Display validation errors -->
                            <div class="card-body">
                                <div class="row gy-3">
                                    <div class="col-12 position-relative">
                                        <div class="form-group" style="width: 327px;">
                                            <label>รหัสพนักงาน <span class="fw-bold text-danger">*</span></label>
                                            <input type="text" name="employee_no" value="{{old('employee_no')}}" class="form-control numericInputInt @error('employee_no') is-invalid @enderror">
                                        </div>
                                        <input type="file" name="avatar" id="avatar-input" accept="image/png, image/jpg, image/jpeg, image/gif" class="form-control" hidden>
                                        <label for="avatar-input">
                                            <div class="d-flex flex-column rounded-4 overflow-hidden position-absolute bottom-0 end-0" style="width: 124px; height: 124px;">
                                                <div class="d-flex justify-content-center align-items-center " style="background: #667085; flex: 1;">
                                                    <img src="{{ asset('icon _user_.png') }}" alt="avatar-preview" id="avatar-preview">
                                                </div>
                                                <div class="d-flex align-items-center justify-content-center" style="height: 30px; background: #D0D5DD;">
                                                    <p class="m-0 text-decoration-underline">เพิ่มรูปภาพ</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>คำนำหน้าชื่อ <span class="fw-bold text-danger">*</span></label>
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
                                            <label>ชื่อ <span class="fw-bold text-danger">*</span></label>
                                            <input type="text" name="name" value="{{old('name')}}"
                                                class="form-control @error('name') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>นามสกุล <span class="fw-bold text-danger">*</span></label>
                                            <input type="text" name="lastname" value="{{old('lastname')}}"
                                                class="form-control @error('lastname') is-invalid @enderror">
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
                                                        calendar_today
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>สัญชาติ <span class="fw-bold text-danger">*</span></label>
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
                                            <label>เชื้อชาติ <span class="fw-bold text-danger">*</span></label>
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
                                            <label>ระดับการศึกษาสูงสุด</label>
                                            <input type="text" name="education" value="{{old('education')}}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>สาขาวิชา</label>
                                            <input type="text" name="edu_department" value="{{old('edu_department')}}"
                                                class="form-control ">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>สถานภาพสมรส</label>
                                            <select name="relationship"
                                                class="form-control select2"
                                                style="width: 100%;">
                                                <option value="1">โสด</option>
                                                <option value="2">แต่งงาน</option>
                                                <option value="3">หย่าร้าง</option>
                                                <option value="4">ไม่ระบุ</option>
                                                {{-- @foreach ($employeeTypes as $employeeType)
                                                <option value="{{ $employeeType->id }}" {{
                                                    old('employeeType')==$employeeType->id
                                                    ?
                                                    'selected' : '' }}>
                                                    {{ $employeeType->name }}
                                                </option>
                                                @endforeach --}}
                                            </select>
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
                                            <label>เลขประจำตัวผู้เสียภาษีอากร</label>
                                            <input type="text" name="tax" value="{{old('tax')}}"
                                                class="form-control numericInputInt">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-end h-100">
                                            <div class="form-check form-check-inline py-2">
                                                <input class="form-check-input" type="checkbox" id="is_foreigner" name="is_foreigner">
                                                <label class="form-check-label" for="is_foreigner">พนักงานต่างชาติ</label>
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
                                                        calendar_today
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
                                </div>
                            </div>
                            <hr>
                            <div class="card-body">
                                <h4 class="m-0">ข้อมูลติดต่อ</h4>
                                <p class="text-muted m-0" style="padding-bottom: 32px;">คำแนะนำกรอก รหัสไปรษณีย์ ก่อน</p>
                                <div class="row gy-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>ที่อยู่ <span class="fw-bold text-danger">*</span></label>
                                            <input type="text" name="address" value="{{old('address')}}"
                                                class="form-control @error('address') is-invalid @enderror">
                                        </div>
                                    </div>
                                    {{-- เพิ่มใหม่ --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>เขต/อำเภอ <span class="fw-bold text-danger">*</span></label>
                                            <select name="district" id="district"
                                                class="form-control select2 @error('district') is-invalid @enderror"
                                                style="width: 100%;">
                                                {{-- @foreach ($userPositions as $userPosition)
                                                <option value="{{ $userPosition->id }}" {{
                                                    old('userPosition')==$userPosition->id
                                                    ?
                                                    'selected' : '' }}>
                                                    {{ $userPosition->name }}
                                                </option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>แขวง/ตำบล <span class="fw-bold text-danger">*</span></label>
                                            <select name="subdistrict" id="subdistrict"
                                                class="form-control select2 @error('subdistrict') is-invalid @enderror"
                                                style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>รหัสไปรษณีย์ <span class="fw-bold text-danger">*</span></label>
                                            <input type="text" class="form-control @error('zip') is-invalid @enderror" style="width: 100%;" id="zip-address">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>จังหวัด <span class="fw-bold text-danger">*</span></label>
                                            <select name="city" id="city"
                                                class="form-control select2 @error('city') is-invalid @enderror"
                                                style="width: 100%;">
                                               
                                                {{-- @foreach ($userPositions as $userPosition)
                                                <option value="{{ $userPosition->id }}" {{
                                                    old('userPosition')==$userPosition->id
                                                    ?
                                                    'selected' : '' }}>
                                                    {{ $userPosition->name }}
                                                </option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>ประเทศ <span class="fw-bold text-danger">*</span></label>
                                            <select name="country"
                                                class="form-control select2 @error('country') is-invalid @enderror"
                                                style="width: 100%;">
                                               <option value="ประเทศไทย">ประเทศไทย</option>
                                            </select>
                                        </div>
                                    </div>
                                    {{-- \\\\ --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>เบอร์โทรศัพท์มือถือ</label>
                                            <input type="text" name="phone" value="{{old('phone')}}"
                                                class="form-control numericInputPhone">
                                        </div>
                                    </div>
                                    {{-- เพิ่มใหม่ --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>อีเมล <span class="fw-bold text-danger">*</span></label>
                                            <input type="email" name="email" value="{{old('email')}}"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="card-body">
                                <h4 class="m-0" style="padding-bottom: 32px;">ข้อมูลการทำงาน</h4>
                                <div class="row gy-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>ประเภทพนักงาน <span class="fw-bold text-danger">*</span></label>
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
                                            <label>ตำแหน่ง <span class="fw-bold text-danger">*</span></label>
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
                                            <label>แผนก <span class="fw-bold text-danger">*</span></label>
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
                                            <label>เริ่มทำงาน <span class="fw-bold text-danger">*</span></label>
                                            <div class="date-box date" id="start_work_date"
                                                data-target-input="nearest">
                                                <input name="startWorkDate" value="{{old('startWorkDate')}}" type="text"
                                                    class="form-control datetimepicker-input @error('startWorkDate') is-invalid @enderror"
                                                    data-target="#start_work_date">
                                                <div class="date-icon" data-target="#start_work_date"
                                                    data-toggle="datetimepicker">
                                                    <span class="material-symbols-outlined">
                                                        calendar_today
                                                    </span>
                                                </div>
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
                                                        calendar_today
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
                                            <label>บัญชีธนาคาร</label>
                                            <input type="text" name="bankAccount" value="{{old('bankAccount')}}"
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
                                            <label>การสแกนเวลาเข้าออก <span class="fw-bold text-danger">*</span></label>
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
                            </div>
                            <div class="card-footer card-create">
                                <a href="{{ route('setting.organization.employee.index') }}" type="button" class="btn btn-outline-secondary">ยกเลิก</a>
                                <button type="submit" class="btn btn-primary">บันทึก</button>
                            </div>
                        </form>
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
    const avatar = document.getElementById('avatar-input');
    const avatarPreview = document.getElementById('avatar-preview');
    avatar.onchange = (event) => {
        avatarPreview.src = URL.createObjectURL(event.target.files[0]);
        avatarPreview.style = 'width: 100%; height: 100%; object-fit: cover;'
    }
    $(document).on('change', '#zip-address', function (e) {
        var postalCode = $('#zip-address').val();

        $.get('{{ route('setting.organization.employee.address', ["postalCode" => "/"]) }}' + "/" +postalCode, function(data) {
            if (data.error) {
                alert(data.error);
                return;
            }
            console.log(data);
            const SubDistrictElement = document.getElementById("subdistrict");
            const DistrictElement = document.getElementById("district");
            const CityElement = document.getElementById("city");
            for (const Subdi of data.subdistricts) {
                const OptionElement = document.createElement('option');
                OptionElement.value = Subdi.subDistrictName;
                OptionElement.innerHTML = Subdi.subDistrictName;
                SubDistrictElement.appendChild(OptionElement);
            }
            for (const Subdi of data.districts) {
                const OptionElement = document.createElement('option');
                OptionElement.value = Subdi.districtName;
                OptionElement.innerHTML = Subdi.districtName;
                DistrictElement.appendChild(OptionElement);
            }
            for (const Subdi of data.provinces) {
                const OptionElement = document.createElement('option');
                OptionElement.value = Subdi.provinceName;
                OptionElement.innerHTML = Subdi.provinceName;
                CityElement.appendChild(OptionElement);
            }
        });
    });
</script>
@endpush
@endsection
