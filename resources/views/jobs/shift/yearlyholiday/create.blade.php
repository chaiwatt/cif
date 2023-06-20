@extends('layouts.pages.dashboard')

@section('content')
@include('dashboard.partial.aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">เพิ่มวันหยุดประจำปี</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('jobs.shift.yearlyholiday')}}">วันหยุดประจำปี</a>
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
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">รายละเอียดวันหยุดประจำปี</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{route('jobs.shift.yearlyholiday.store')}}" method="POST">
                                @csrf
                                <!-- Display validation errors -->
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>วันหยุด<span class="small text-danger">*</span></label>
                                            <input type="text" name="holiday" value="{{old('holiday')}}"
                                                class="form-control @error('holiday') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>วันที่</label><span class="small text-danger">*</span>
                                            <div class="input-group date" id="holiday_date" data-target-input="nearest">
                                                <input name="HolidayDate" value="{{old('HolidayDate')}}" type="text"
                                                    class="form-control datetimepicker-input @error('holiday') is-invalid @enderror"
                                                    data-target="#holiday_date">
                                                <div class="input-group-append" data-target="#holiday_date"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
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
    $(function () {
        //Date picker
        $('#holiday_date').datetimepicker({
            format: 'L'
        });
    });
    
</script>
@endpush
@endsection