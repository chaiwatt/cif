@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="title-header">
                <div>
                    <h3 class="m-0">การทำงาน: {{$shift->name}}</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.time-recording-system.shift.timeattendance')}}">กะการทำงาน</a>
                        </li>
                        <li class="breadcrumb-item active">{{$shift->name}}</li>
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
                            <h4 class="card-title">รายละเอียดกะการทำงาน</h4>
                        </div>
                        <form action="{{ route('groups.time-recording-system.shift.timeattendance.update', ['id' => $shift->id]) }}" method="POST">
                        <div class="card-body">
                                @method('PUT')
                                @csrf
                                <!-- Display validation errors -->
                                <div class="row gy-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ชื่อกะ <span class="fw-bold text-danger">*</span></label>
                                            <input type="text" name="shift" value="{{old('shift') ?? $shift->name}}"
                                                class="form-control @error('shift') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>คำอธิบาย</label>
                                            <input type="text" name="description"
                                                value="{{old('description') ?? $shift->description}}"
                                                class="form-control ">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>year <span class="fw-bold text-danger">*</span></label>
                                            <select name="year"
                                                class="form-control select2 @error('year') is-invalid @enderror"
                                                style="width: 100%;">
                                                @foreach ($years as $year)
                                                <option value="{{ $year }}" @if ($year==$shift->year) selected @endif>
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
                                                    value="{{old('timepicker_start') ?? $shift->start}}"
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
                                                    value="{{old('timepicker_end') ?? $shift->end}}"
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
                                                value="{{old('record_start_hour') ?? $shift->record_start}}"
                                                class="form-control numericInputSingle @error('record_start_hour') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>เวลาบันทึกออก (ชั่วโมง) <span
                                                    class="fw-bold text-danger">*</span></label>
                                            <input type="text" name="record_end_hour"
                                                value="{{old('record_end_hour') ?? $shift->record_end}}"
                                                class="form-control numericInputSingle @error('record_end_hour') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ประเภทกะทำงาน <span class="fw-bold text-danger">*</span></label>
                                            <select name="shiftType"
                                                class="form-control select2 @error('shiftType') is-invalid @enderror"
                                                style="width: 100%;">
                                                <option value="">==เลือก==</option>
                                                @foreach ($shiftTypes as $shiftType)
                                                <option value="{{ $shiftType->id }}" @if ($shiftType->id ==
                                                    $shift->shift_type_id) selected @endif>
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
                                                    value="{{old('timepicker_break_start') ?? $shift->break_start}}"
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
                                                    value="{{old('timepicker_break_end') ?? $shift->break_end}}"
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
                                            <label>จำนวนชั่วโมงงาน <span class="fw-bold text-danger">*</span></label>
                                            <input type="text" name="duration"
                                                value="{{old('duration') ?? $shift->duration}}"
                                                class="form-control numericInputSingle @error('duration') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>จำนวนชั่วพัก <span class="fw-bold text-danger">*</span></label>
                                            <input type="text" name="break_hour"
                                                value="{{old('break_hour') ?? $shift->break_hour}}"
                                                class="form-control numericInputSingle @error('break_hour') is-invalid @enderror">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>ค่าตอบแทน <span class="fw-bold text-danger">*</span></label>
                                            <input type="text" name="multiply"
                                                value="{{old('multiply') ?? $shift->multiply}}"
                                                class="form-control numericInputSingle @error('multiply') is-invalid @enderror">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer card-create">
                                <a href="{{ route('groups.time-recording-system.shift.timeattendance') }}" class="btn btn-outline-secondary" type="button">ยกเลิก</a>
                                <button class="btn btn-primary" type="submit">บันทึก</button>
                            </div>
                        </form>
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