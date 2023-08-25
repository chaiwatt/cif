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
                    <h1 class="m-0">บันทึกเวลาและเงินได้ / เงินหัก: {{$user->prefix->name}}{{$user->name}}
                        {{$user->lastname}}
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.time-recording-system.schedulework.time-recording')}}">ตารางทำงาน</a>
                        </li>
                        <li class="breadcrumb-item active">นำเข้าไฟล์เวลา</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($permission->show)
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline card-tabs">
                        <div class="card-header p-0 pt-1 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="time-tab-tab" data-toggle="pill" href="#time-tab"
                                        role="tab" aria-controls="time-tab" aria-selected="true">บันทึกเวลา</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="income-deducy-tab-tab" data-toggle="pill"
                                        href="#income-deducy-tab" role="tab" aria-controls="income-deducy-tab"
                                        aria-selected="false">เงินได้ / เงินหัก</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                <div class="tab-pane fade active show" id="time-tab" role="tabpanel"
                                    aria-labelledby="time-tab-tab">
                                    <div class="row">
                                        <div class="col-sm-12" id="table_container">
                                            <table class="table table-bordered table-striped dataTable dtr-inline">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 10%">วันที่</th>
                                                        <th class="text-center" style="width: 10%">เวลารูดบัตร</th>
                                                        <th class="text-center" style="width: 10%">ชม.งาน</th>
                                                        <th class="text-center" style="width: 10%">มาสาย</th>
                                                        <th class="text-center" style="width: 10%">กลับก่อน</th>
                                                        <th class="text-center" style="width: 10%">ลาป่วย</th>
                                                        <th class="text-center" style="width: 10%">ลากิจ</th>
                                                        <th class="text-center" style="width: 10%">พักร้อน</th>
                                                        <th class="text-center" style="width: 10%">ขาดงาน</th>
                                                        <th class="text-center" style="width: 10%">ล่วงเวลา</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($workScheduleAssignmentUsers as $key =>
                                                    $workScheduleAssignmentUser)
                                                    @php
                                                    $paydayDetailWithToday =
                                                    $workScheduleAssignmentUser->user->getPaydayDetailWithToday();
                                                    $getWorkHour =
                                                    $workScheduleAssignmentUser->getWorkHour();
                                                    @endphp
                                                    <tr>
                                                        <td class="text-center">{{
                                                            \Carbon\Carbon::createFromFormat('Y-m-d',
                                                            $workScheduleAssignmentUser->date_in)->format('d/m/Y')
                                                            }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if($workScheduleAssignmentUser->time_in &&
                                                            $workScheduleAssignmentUser->time_out)
                                                            {{ \Carbon\Carbon::createFromFormat('H:i:s',
                                                            $workScheduleAssignmentUser->time_in)->format('H:i')
                                                            }} -
                                                            {{ \Carbon\Carbon::createFromFormat('H:i:s',
                                                            $workScheduleAssignmentUser->time_out)->format('H:i')
                                                            }}
                                                            @endif</td>

                                                        <td class="text-center">{{$getWorkHour['workHour']}}</td>
                                                        <td class="text-center">{{$getWorkHour['lateHour']}}</td>
                                                        <td class="text-center">{{$getWorkHour['earlyHour']}}</td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center">{{$getWorkHour['absentCount']}}</td>
                                                        <td class="text-center"></td>


                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="income-deducy-tab" role="tabpanel"
                                    aria-labelledby="income-deducy-tab-tab">
                                    <table class="table table-bordered table-striped dataTable dtr-inline">
                                        <thead>
                                            <tr>
                                                <th>เงินเพิ่ม / เงินหัก</th>
                                                <th>จำนวน</th>
                                                <th>หน่วย</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($user->getIncomeDeductByUsers() as $incomeDeductByUser)
                                            <tr>
                                                <td>{{$incomeDeductByUser->incomeDeduct->name}}</td>
                                                <td>{{$incomeDeductByUser->value}}</td>
                                                <td>{{$incomeDeductByUser->incomeDeduct->unit->name}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-12">

                </div>

            </div>

            @endif

        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    {{-- <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button> --}}
    <button type="button" class="btn btn-primary" id="bntUpdateReportField">ต่อไป</button>
</div>
</div>
</div>
</div>
</div>
@push('scripts')

<script type="module"
    src="{{ asset('assets/js/helpers/time-recording-system/schedulework/time-recording-check-current-payday/index.js?v=1') }}">
</script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        // searchRoute: '{{ route('groups.time-recording-system.schedulework.time-recording-check-current-payday.search') }}',        
        // viewUserRoute: '{{ route('groups.time-recording-system.schedulework.time-recording-check-current-payday.view-user') }}',
        // updateRoute: '{{ route('groups.time-recording-system.schedulework.time-recording-check-current-payday.update') }}',
        // getImageRoute: '{{ route('groups.time-recording-system.schedulework.time-recording-check-current-payday.get-image') }}',
        // uploadImageRoute: '{{ route('groups.time-recording-system.schedulework.time-recording-check-current-payday.upload-image') }}',
        // deleteImageRoute: '{{ route('groups.time-recording-system.schedulework.time-recording-check-current-payday.delete-image') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection