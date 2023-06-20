@extends('layouts.pages.dashboard')

@section('content')
@include('dashboard.partial.aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">เพิ่มกะการทำงาน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('jobs.shift.timeattendance')}}">กะการทำงาน</a></li>
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
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">รายละเอียดกะการทำงาน</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{route('jobs.shift.timeattendance.store')}}" method="POST">
                                @csrf
                                <!-- Display validation errors -->
                                <div class="row">
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
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>เวลาเข้างาน</label>
                                            <div class="input-group date" id="timepicker_start"
                                                data-target-input="nearest">
                                                <input type="text" name="timepicker_start"
                                                    value="{{old('timepicker_start')}}"
                                                    class="form-control datetimepicker-input @error('timepicker_start') is-invalid @enderror"
                                                    data-target="#timepicker_start">
                                                <div class="input-group-append" data-target="#timepicker_start"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>เวลาออกงาน</label>
                                            <div class="input-group date" id="timepicker_end"
                                                data-target-input="nearest">
                                                <input type="text" name="timepicker_end"
                                                    value="{{old('timepicker_end')}}"
                                                    class="form-control datetimepicker-input @error('timepicker_end') is-invalid @enderror"
                                                    data-target="#timepicker_end">
                                                <div class="input-group-append" data-target="#timepicker_end"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>เวลาบันทึกเข้างาน</label>
                                            <div class="input-group date" id="timepicker_record_start"
                                                data-target-input="nearest">
                                                <input type="text" name="timepicker_record_start"
                                                    value="{{old('timepicker_record_start')}}"
                                                    class="form-control datetimepicker-input @error('timepicker_record_start') is-invalid @enderror"
                                                    data-target="#timepicker_record_start">
                                                <div class="input-group-append" data-target="#timepicker_record_start"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>เวลาบันทึกออกงาน</label>
                                            <div class="input-group date" id="timepicker_record_end"
                                                data-target-input="nearest">
                                                <input type="text" name="timepicker_record_end"
                                                    value="{{old('timepicker_record_end')}}"
                                                    class="form-control datetimepicker-input @error('timepicker_record_end') is-invalid @enderror"
                                                    data-target="#timepicker_record_end">
                                                <div class="input-group-append" data-target="#timepicker_record_end"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>เวลาเริ่มพัก</label>
                                            <div class="input-group date" id="timepicker_break_start"
                                                data-target-input="nearest">
                                                <input type="text" name="timepicker_break_start"
                                                    value="{{old('timepicker_break_start')}}"
                                                    class="form-control datetimepicker-input @error('timepicker_break_start') is-invalid @enderror"
                                                    data-target="#timepicker_break_start">
                                                <div class="input-group-append" data-target="#timepicker_break_start"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>เวลาสิ้นสุดพัก</label>
                                            <div class="input-group date" id="timepicker_break_end"
                                                data-target-input="nearest">
                                                <input type="text" name="timepicker_break_end"
                                                    value="{{old('timepicker_break_end')}}"
                                                    class="form-control datetimepicker-input @error('timepicker_break_end') is-invalid @enderror"
                                                    data-target="#timepicker_break_end">
                                                <div class="input-group-append" data-target="#timepicker_break_end"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>จำนวนชั่วโมงงาน<span class="small text-danger">*</span></label>
                                            <input type="text" name="duration" value="{{old('duration')}}"
                                                class="form-control numericInput @error('duration') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>จำนวนชั่วพัก<span class="small text-danger">*</span></label>
                                            <input type="text" name="break_hour" value="{{old('break_hour')}}"
                                                class="form-control numericInputSingle @error('break_hour') is-invalid @enderror">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>ค่าตอบแทน<span class="small text-danger">*</span></label>
                                            <input type="text" name="multiply" value="{{old('multiply')}}"
                                                class="form-control numericInputSingle @error('multiply') is-invalid @enderror">
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
<script src="{{ asset('assets/js/helper/form-maks.js') }}"></script>
<script>
    const timepickerConfig = {
        format: 'HH:mm'
    };
    $('#timepicker_start, #timepicker_end, #timepicker_record_start, #timepicker_record_end, #timepicker_break_start,#timepicker_break_end').datetimepicker(timepickerConfig);  

</script>
@endpush
@endsection