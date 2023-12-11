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
                    <h1 class="m-0">รายงานเดือน{{$month->name}}
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a>
                        </li>
                        <li class="breadcrumb-item active">รายงาน</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">

            @if ($permission->show)
            @php
            $previousSalarySummary = 0;
            $previousOvertime = 0;
            $previousAllowanceDiligenceSummary = 0;
            $previousIncomeSummary = 0;
            $previousDeductSummary = 0;
            $previousLeaveSummary = 0;
            $previousAbsentSummary = 0;
            foreach ($previousPaydayDetails as $previousPaydayDetail) {
            $previousSalarySummary += $previousPaydayDetail->salarySummary->sum('sum_salary');
            $previousOvertime += $previousPaydayDetail->salarySummary->sum('sum_overtime');
            $previousAllowanceDiligenceSummary += $previousPaydayDetail->salarySummary->sum('sum_allowance_diligence');
            $previousIncomeSummary += $previousPaydayDetail->salarySummary->sum('sum_income');
            $previousDeductSummary += $previousPaydayDetail->salarySummary->sum('sum_deduct');
            $previousLeaveSummary += $previousPaydayDetail->salarySummary->sum('sum_leave');
            $previousAbsentSummary += $previousPaydayDetail->salarySummary->sum('sum_absence');
            }
            @endphp

            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-wallet"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">เงินเดือน</span>
                            <span class="info-box-number">{{number_format($previousSalarySummary,2)}}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="far fa-clock"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">ล่วงเวลา</span>
                            <span class="info-box-number">{{number_format($previousOvertime,2)}}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-medal"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">เบี้ยขยัน</span>
                            <span class="info-box-number">{{number_format($previousAllowanceDiligenceSummary,2)}}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="fas fa-hand-holding-usd"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">รายได้อื่นๆ</span>
                            <span class="info-box-number">{{number_format($previousIncomeSummary,2)}}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-cut"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">หักอื่นๆ</span>
                            <span class="info-box-number">{{number_format($previousDeductSummary,2)}}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-leaf"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">ลางาน</span>
                            <span class="info-box-number">{{$previousLeaveSummary}}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-dark"><i class="far fa-flag"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">ขาดงาน</span>
                            <span class="info-box-number">{{$previousAbsentSummary}}</span>
                        </div>
                    </div>
                </div>

            </div>
            <hr>
            <h3 class="mb-2">รายงานเงินเดือน
            </h3>
            <div class="row">
                <div class="col-12">
                    <div class="card card-info card-outline card-tabs">
                        <div class="card-header p-0 pt-1 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                @foreach ($paydays->where('type',1) as $key => $payday)
                                <li class="nav-item">
                                    <a class="nav-link {{ $key === 0 ? 'active' : '' }}"
                                        id="custom-tabs-{{$payday->id}}-tab" data-toggle="pill"
                                        href="#custom-tabs-{{$payday->id}}" role="tab"
                                        aria-controls="custom-tabs-{{$payday->id}}"
                                        aria-selected="true">{{$payday->name}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                @foreach ($paydays->where('type',1) as $key => $payday)
                                <div class="tab-pane fade show {{ $key === 0 ? 'active' : '' }}"
                                    id="custom-tabs-{{$payday->id}}" role="tabpanel"
                                    aria-labelledby="custom-tabs-{{$payday->id}}-tab">
                                    <table class="table table-bordered table-striped dataTable dtr-inline">
                                        <thead>
                                            <tr>
                                                <th>เดือน</th>
                                                <th class="text-center">เงินเดือน</th>
                                                <th class="text-center">ค่าล่วงเวลา</th>
                                                <th class="text-center">เบี้ยขยัน</th>
                                                <th class="text-center">รายได้อื่นๆ</th>
                                                <th class="text-center">หักอื่นๆ</th>
                                                <th class="text-center">ประกันสังคม</th>
                                                <th class="text-right" style="width: 150px">เพิ่มเติม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($payday->paydayDetails as $paydayDetail)
                                            <tr>
                                                <td>{{$paydayDetail->month->name}} {{$paydayDetail->payday->year}}</td>

                                                <td class="text-center">{{
                                                    $paydayDetail->salarySummary->sum('sum_salary') != 0 ?
                                                    number_format($paydayDetail->salarySummary->sum('sum_salary'),2) :
                                                    ''}}
                                                </td>
                                                <td class="text-center">{{
                                                    $paydayDetail->salarySummary->sum('sum_overtime') != 0 ?
                                                    number_format($paydayDetail->salarySummary->sum('sum_overtime'),2) :
                                                    ''}}</td>
                                                <td class="text-center">{{
                                                    $paydayDetail->salarySummary->sum('sum_allowance_diligence') != 0
                                                    ?
                                                    number_format($paydayDetail->salarySummary->sum('sum_allowance_diligence'),2)
                                                    :
                                                    ''}}
                                                </td>
                                                <td class="text-center">{{
                                                    $paydayDetail->salarySummary->sum('sum_income') != 0
                                                    ?
                                                    number_format($paydayDetail->salarySummary->sum('sum_income'),2)
                                                    :
                                                    ''}}</td>
                                                <td class="text-center">{{
                                                    $paydayDetail->salarySummary->sum('sum_deduct') != 0
                                                    ?
                                                    number_format($paydayDetail->salarySummary->sum('sum_deduct'),2)
                                                    :
                                                    ''}}</td>
                                                <td class="text-center">{{
                                                    $paydayDetail->salarySummary->sum('sum_social_security') != 0
                                                    ?
                                                    number_format($paydayDetail->salarySummary->sum('sum_social_security'),2)
                                                    :
                                                    ''}}</td>
                                                <td class="text-right">
                                                    @if ($paydayDetail->salarySummary->sum('employee')
                                                    != 0)
                                                    <a class="btn btn-sm btn-info "
                                                        href="{{route('groups.salary-system.salary.calculation-list.summary.download-report',['payday_detail_id' => $paydayDetail->id])}}">
                                                        <i class="fas fa-download "></i>

                                                    </a>
                                                    <a class="btn btn-sm btn-primary "
                                                        href="{{route('groups.report-system.report.salary.view',['id' => $paydayDetail->id ])}}"><i
                                                            class="fas fa-eye"></i></a>
                                                    @endif

                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <hr>
            <h3 class="mb-2">รายงานขาด ลา
            </h3>
            <div class="row">
                <div class="col-12">
                    <div class="card card-info card-outline card-tabs">
                        <div class="card-header p-0 pt-1 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-arttendance-tabs-three-tab" role="tablist">
                                @foreach ($paydays->where('type',1) as $key => $payday)
                                <li class="nav-item">
                                    <a class="nav-link {{ $key === 0 ? 'active' : '' }}"
                                        id="custom-arttendance-tabs-{{$payday->id}}-tab" data-toggle="pill"
                                        href="#custom-arttendance-tabs-{{$payday->id}}" role="tab"
                                        aria-controls="custom-arttendance-tabs-{{$payday->id}}"
                                        aria-selected="true">{{$payday->name}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-arttendance-tabs-three-tabContent">
                                @foreach ($paydays->where('type',1) as $key => $payday)
                                <div class="tab-pane fade show {{ $key === 0 ? 'active' : '' }}"
                                    id="custom-arttendance-tabs-{{$payday->id}}" role="tabpanel"
                                    aria-labelledby="custom-arttendance-tabs-{{$payday->id}}-tab">
                                    <table class="table table-bordered table-striped dataTable dtr-inline">
                                        <thead>
                                            <tr>
                                                <th>เดือน</th>
                                                <th class="text-center">ขาดงาน</th>
                                                <th class="text-center">ลางาน</th>
                                                <th class="text-right" style="width: 150px">เพิ่มเติม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($payday->paydayDetails as $paydayDetail)
                                            <tr>
                                                <td>{{$paydayDetail->month->name}} {{$paydayDetail->payday->year}}</td>

                                                <td class="text-center">{{
                                                    $paydayDetail->salarySummary->sum('sum_leave') != 0 ?
                                                    $paydayDetail->salarySummary->sum('sum_leave') :
                                                    ''}}
                                                </td>
                                                <td class="text-center">{{
                                                    $paydayDetail->salarySummary->sum('sum_absence') != 0 ?
                                                    $paydayDetail->salarySummary->sum('sum_absence') :
                                                    ''}}</td>


                                                <td class="text-right">
                                                    @if ($paydayDetail->salarySummary->sum('sum_leave')
                                                    != 0 || $paydayDetail->salarySummary->sum('sum_absence')
                                                    != 0)
                                                    <a class="btn btn-sm btn-primary "
                                                        href="{{route('groups.report-system.report.salary.attendance',['id' => $paydayDetail->id ])}}"><i
                                                            class="fas fa-eye"></i></a>
                                                    @endif

                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>




            </div>
            @endif

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