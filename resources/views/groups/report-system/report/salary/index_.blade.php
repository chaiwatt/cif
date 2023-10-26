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
                    <h1 class="m-0">รายงาน
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">รายงานรวม</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12" id="table_container">
                                    <table class="table table-bordered table-striped dataTable dtr-inline">
                                        <thead>
                                            <tr>
                                                <th>เดือน</th>
                                                <th class="text-center">พนักงาน</th>
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
                                            @foreach ($paydayDetails as $paydayDetail)
                                            <tr>
                                                <td>{{$paydayDetail->month->name}} {{$paydayDetail->payday->year}}</td>
                                                <td class="text-center">{{ $paydayDetail->salarySummary->sum('employee')
                                                    != 0 ?
                                                    $paydayDetail->salarySummary->sum('employee'):
                                                    ''}}</td>
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