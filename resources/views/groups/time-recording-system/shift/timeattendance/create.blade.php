@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">เพิ่มกะการทำงาน</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.time-recording-system.shift.timeattendance')}}">กะการทำงาน</a>
                        </li>
                        <li class="breadcrumb-item active">เพิ่มกะการทำงาน</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">รายละเอียดกะการทำงาน</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('groups.time-recording-system.shift.timeattendance.store')}}"
                                method="POST">
                                @csrf

                                <div class="row gy-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ชื่อกะ<span class="small text-danger">*</span></label>
                                            <input type="text" name="shift" value="{{old('shift')}}"
                                                class="form-control @error('shift') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>คำอธิบาย</label>
                                            <input type="text" name="description" value="{{old('description')}}"
                                                class="form-control ">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ปี<span class="small text-danger">*</span></label>
                                            <select name="year"
                                                class="form-control select2 @error('year') is-invalid @enderror"
                                                style="width: 100%;">
                                                @foreach ($years as $year)
                                                <option value="{{ $year }}" {{ old('year')==$year? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>เวลาเข้างาน</label>
                                            <div class="date-box date" id="timepicker_start"
                                                data-target-input="nearest">
                                                <input type="text" name="timepicker_start"
                                                    value="{{old('timepicker_start')}}"
                                                    class="form-control datetimepicker-input @error('timepicker_start') is-invalid @enderror"
                                                    data-target="#timepicker_start">
                                                <div class="date-icon" data-target="#timepicker_start"
                                                    data-toggle="datetimepicker">
                                                    <span class="material-symbols-outlined">
                                                        schedule
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>เวลาออกงาน</label>
                                            <div class="date-box date" id="timepicker_end"
                                                data-target-input="nearest">
                                                <input type="text" name="timepicker_end"
                                                    value="{{old('timepicker_end')}}"
                                                    class="form-control datetimepicker-input @error('timepicker_end') is-invalid @enderror"
                                                    data-target="#timepicker_end">
                                                <div class="date-icon" data-target="#timepicker_end"
                                                    data-toggle="datetimepicker">
                                                    <span class="material-symbols-outlined">
                                                        schedule
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>เวลาบันทึกเข้า (ชั่วโมง)<span
                                                    class="small text-danger">*</span></label>
                                            <input type="text" name="record_start_hour"
                                                value="{{old('record_start_hour') ?? '2.0'}}"
                                                class="form-control numericInputSingle @error('record_start_hour') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>เวลาบันทึกออก (ชั่วโมง)<span
                                                    class="small text-danger">*</span></label>
                                            <input type="text" name="record_end_hour"
                                                value="{{old('record_end_hour') ?? '6.5'}}"
                                                class="form-control numericInputSingle @error('record_end_hour') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ประเภทกะทำงาน<span class="small text-danger">*</span></label>
                                            <select name="shiftType"
                                                class="form-control select2 @error('shiftType') is-invalid @enderror"
                                                style="width: 100%;">
                                                <option value="">==เลือก==</option>
                                                @foreach ($shiftTypes as $shiftType)
                                                <option value="{{ $shiftType->id }}" {{ old('shiftType')==$shiftType->id
                                                    ?
                                                    'selected' : '' }}>
                                                    {{ $shiftType->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>เวลาเริ่มพัก</label>
                                            <div class="date-box date" id="timepicker_break_start"
                                                data-target-input="nearest">
                                                <input type="text" name="timepicker_break_start"
                                                    value="{{old('timepicker_break_start')}}"
                                                    class="form-control datetimepicker-input @error('timepicker_break_start') is-invalid @enderror"
                                                    data-target="#timepicker_break_start">
                                                <div class="date-icon" data-target="#timepicker_break_start"
                                                    data-toggle="datetimepicker">
                                                    <span class="material-symbols-outlined">
                                                        schedule
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>เวลาสิ้นสุดพัก</label>
                                            <div class="date-box date" id="timepicker_break_end"
                                                data-target-input="nearest">
                                                <input type="text" name="timepicker_break_end"
                                                    value="{{old('timepicker_break_end')}}"
                                                    class="form-control datetimepicker-input @error('timepicker_break_end') is-invalid @enderror"
                                                    data-target="#timepicker_break_end">
                                                <div class="date-icon" data-target="#timepicker_break_end"
                                                    data-toggle="datetimepicker">
                                                    <span class="material-symbols-outlined">
                                                        schedule
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>จำนวนชั่วโมงงาน<span class="small text-danger">*</span></label>
                                            <input type="text" name="duration" value="{{old('duration') ?? '8.0'}}"
                                                class="form-control numericInputSingle @error('duration') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>จำนวนชั่วพัก<span class="small text-danger">*</span></label>
                                            <input type="text" name="break_hour" value="{{old('break_hour') ?? '1.0'}}"
                                                class="form-control numericInputSingle @error('break_hour') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>ค่าตอบแทน<span class="small text-danger">*</span></label>
                                            <input type="text" name="multiply" value="{{old('multiply') ?? '1.0'}}"
                                                class="form-control numericInputSingle @error('multiply') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
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
<script src="{{ asset('assets/js/helpers/helper.js?v=1') }}"></script>
<script>
    $('.select2').select2()
    const timepickerConfig = {
        format: 'HH:mm'
    };
    $('#timepicker_start, #timepicker_end, #record_start_hour, #record_end_hour, #timepicker_break_start,#timepicker_break_end').datetimepicker(timepickerConfig);  

</script>
@endpush
@endsection