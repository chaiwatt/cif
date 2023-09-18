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
                    <h1 class="m-0">รายการบันทึกเวลา
                    </h1>
                    <ul class="mt-2">
                        @foreach ($paydayDetails as $paydayDetail)
                        <li>
                            <h4>{{$paydayDetail->payday->name}} (รอบเงินเดือน {{date('d/m/Y',
                                strtotime($paydayDetail->start_date))}}
                                -
                                {{date('d/m/Y', strtotime($paydayDetail->end_date))}})</h4>
                        </li>
                        @endforeach
                    </ul>
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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">พนักงาน</h3>
                            @if (count($users) !=0)
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="search_query" id="search_query"
                                        class="form-control float-right" placeholder="ค้นหา">
                                </div>
                            </div>
                            @endif

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12" id="table_container">
                                    <table class="table table-bordered table-striped dataTable dtr-inline">
                                        <thead>
                                            <tr>
                                                <th>รหัสพนักงาน</th>
                                                <th>ชื่อ-สกุล</th>
                                                <th class="text-center">ชม.งาน</th>
                                                <th class="text-center">มาสาย(ชม.)</th>
                                                <th class="text-center">กลับก่อน(ชม.)</th>
                                                <th class="text-center">วันลา</th>
                                                <th class="text-center">ขาดงาน</th>
                                                <th class="text-center">ล่วงเวลา</th>
                                                <th class="text-center">เบี้ยขยัน</th>
                                                <th class="text-right" style="width: 120px">เพิ่มเติม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                            @php
                                            $paydayDetailWithToday = $user->getPaydayDetailWithToday();
                                            $userSummary = $user->userSummary();
                                            @endphp
                                            <tr>

                                                <td>
                                                    @if (count($user->getErrorDate()) > 0)
                                                    <i class="fas fa-times-circle text-danger"></i>
                                                    @else
                                                    <i class="fas fa-check-circle text-success"></i>
                                                    @endif
                                                    {{ $user->employee_no }}
                                                    {{-- @php
                                                    $isvalidTimeInOuts =
                                                    $user->IsvalidTimeInOut($paydayDetailWithToday->start_date,$paydayDetailWithToday->end_date)

                                                    @endphp

                                                    @if (count($isvalidTimeInOuts) != 0)
                                                    <i class="fas fa-times-circle text-danger"></i>
                                                    @endif --}}

                                                </td>
                                                <td>{{ $user->prefix->name }}{{
                                                    $user->name }} {{
                                                    $user->lastname }}</td>
                                                {{-- <td>{{$user->getPaydayWithToday()->name}}</td> --}}
                                                <td class="text-center">{{$userSummary['workHour']}}</td>
                                                <td class="text-center">{{$userSummary['lateHour']}}</td>
                                                <td class="text-center">{{$userSummary['earlyHour']}}</td>
                                                <td class="text-center">{{$userSummary['leaveCountSum']}}</td>
                                                <td class="text-center">{{$userSummary['absentCountSum']}}</td>
                                                <td class="text-center">{{$userSummary['overTime']}}</td>
                                                <td class="text-center">{{$userSummary['deligenceAllowance']}}
                                                </td>
                                                <td class="text-right">

                                                    <a class="btn btn-sm btn-info btn-user" data-id="{{$user->id}}"
                                                        data-startDate="{{$paydayDetailWithToday->start_date}}"
                                                        data-endDate="{{$paydayDetailWithToday->end_date}}"
                                                        href="{{route('groups.salary-system.salary.calculation.information',['start_date' => $paydayDetailWithToday->start_date,'end_date' => $paydayDetailWithToday->end_date,'user_id' => $user->id] )}}"><i
                                                            class="far fa-list-alt"></i></a>
                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{$users->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
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

<script type="module" src="{{ asset('assets/js/helpers/salary-system/salary/calculation/index.js?v=1') }}">
</script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        searchRoute: '{{ route('groups.salary-system.salary.calculation.search') }}',        
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection