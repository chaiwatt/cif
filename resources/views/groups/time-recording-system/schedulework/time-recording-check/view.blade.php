@extends('layouts.dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/loading.css?v=1.0') }}">
@endpush
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    @include('layouts.partial.loading')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{$month->name}} {{$year}} ({{$workSchedule->name}})
                    </h1>
                    <input type="text" id="schedule_type_id" value="{{$workSchedule->schedule_type_id}}" hidden>
                    <input type="text" id="work_schedule_id" value="{{$workSchedule->id}}" hidden>
                    <input type="text" id="month_id" value="{{$month->id}}" hidden>
                    <input type="text" id="year" value="{{$year}}" hidden>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.time-recording-system.schedulework.time-recording')}}">ตารางทำงาน</a>
                        </li>
                        <li class="breadcrumb-item active">{{$month->name}} {{$year}} ({{$workSchedule->name}})</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <a class="btn btn-primary mb-3" id="show_modal">
                ตรวจสอบการบันทึกเวลา
            </a>
            @if ($permission->show)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">พนักงาน</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12" id="table_container">
                                    <table class="table table-bordered table-striped dataTable dtr-inline">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 150px">ตรวจสอบ</th>
                                                <th style="width: 200px">วันที่ผิดพลาด</th>
                                                <th style="width: 200px">รหัสพนักงาน</th>
                                                <th>ชื่อ-สกุล</th>
                                                <th>แผนก</th>
                                                <th class="text-right" style="width: 120px">แก้ไข</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            @endif

        </div>
    </div>
    <div class="modal fade" id="modal-date-range">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="startDate">เริ่มวันที่ (วดป. คศ)<span
                                        class="small text-danger">*</span></label>
                                <input type="text" class="form-control input-date-format" id="startDate">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="endDate">ถึงวันที่ (วดป. คศ)<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control input-date-format" id="endDate">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group float-right">
                                <button type="button" class="btn btn-primary" id="check-time-record">ตกลง</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-user-time-record">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12" id="table_modal_container">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>
</div>
</div>
@push('scripts')
<script type="module"
    src="{{ asset('assets/js/helpers/time-recording-system/schedule/time-recording/time-recording-check.js?v=1') }}">
</script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        timeRecordCheckRoute: '{{ route('groups.time-recording-system.schedulework.time-recording-check.time-record-check') }}',        
        viewUserRoute: '{{ route('groups.time-recording-system.schedulework.time-recording-check.view-user') }}',
        updateRoute: '{{ route('groups.time-recording-system.schedulework.time-recording-check.update') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection