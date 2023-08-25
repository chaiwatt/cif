@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">รายการล่วงเวลา</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.document-system.overtime.document')}}">รายการล่วงเวลา</a>
                        </li>
                        <li class="breadcrumb-item active">รายการล่วงเวลา</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <input type="text" id="leaveId" value="" hidden>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">เพิ่มรายการล่วงเวลา</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form
                                action="{{route('groups.document-system.overtime.document.update',['id' => $overtime->id])}}"
                                method="POST">
                                @method('PUT')
                                @csrf

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ชื่อรายการล่วงเวลา<span class="small text-danger">*</span></label>
                                            <input type="text" name="name" id="name"
                                                value="{{old('name') ?? $overtime->name}}"
                                                class="form-control  @error('name') is-invalid @enderror">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>วันที่เริ่ม (วดป. คศ)<span class="small text-danger">*</span></label>
                                            <input type="text" name="startDate" id="startDate" value="{{old('startDate') ?? \Carbon\Carbon::createFromFormat('Y-m-d',
                                                $overtime->from_date)->format('d/m/Y')}} {{$overtime->start_time}}"
                                                class="form-control input-datetime-format @error('startDate') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ถึงวันที่ (วดป. คศ)<span class="small text-danger">*</span></label>
                                            <input type="text" name="endDate" id="endDate" value="{{old('endDate') ?? \Carbon\Carbon::createFromFormat('Y-m-d',
                                                $overtime->to_date)->format('d/m/Y')}} {{$overtime->end_time}}"
                                                class="form-control input-datetime-format @error('endDate') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-12 text-right">
                                        <button class="btn bg-success">บันทึก</button>
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
    $('#timepicker_start, #timepicker_end').datetimepicker(timepickerConfig);  

</script>
@endpush
@endsection