@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">เพิ่มวันหยุดประจำปี</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.time-recording-system.shift.yearlyholiday')}}">วันหยุดประจำปี</a>
                        </li>
                        <li class="breadcrumb-item active">เพิ่มวันหยุดประจำปี</li>
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
                            <h4 class="card-title">รายละเอียดวันหยุดประจำปี</h4>
                        </div>
                        <form action="{{route('groups.time-recording-system.shift.yearlyholiday.store')}}"
                            method="POST">
                            <div class="card-body">
                                @csrf
                                <!-- Display validation errors -->
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>วันหยุด <span class="fw-bold text-danger">*</span></label>
                                            <input type="text" name="holiday" value="{{old('holiday')}}"
                                                class="form-control @error('holiday') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>วันที่ <span class="fw-bold text-danger">*</span></label>
                                            <div class="date-box date" id="holiday_date" data-target-input="nearest">
                                                <input name="HolidayDate" value="{{old('HolidayDate')}}" type="text"
                                                    class="form-control datetimepicker-input @error('holiday') is-invalid @enderror"
                                                    data-target="#holiday_date">
                                                <div class="date-icon" data-target="#holiday_date"
                                                    data-toggle="datetimepicker">
                                                    <span class="material-symbols-outlined">
                                                        today
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cif-modal-footer">
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
<script src="{{ asset('assets/js/helpers/helper.js?v=1') }}"></script>
<script>
    $(function () {
        //Date picker
        $('#holiday_date').datetimepicker({
            format: 'L'
        });
    });
    
</script>
@endpush
@endsection