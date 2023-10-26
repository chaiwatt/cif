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
            <div class="row mb-0">
                <div class="col-sm-6">
                    <h1 class="m-0">รายการเงินเดือนงวดปกติ @if (count($salarySummaries) != 0)
                        <span class="text-danger">(ปิดงวด)</span>
                        @endif
                    </h1>
                    <ul class="mt-2">
                        <li>
                            <h4>{{$paydayDetail->payday->name}} (รอบเงินเดือน {{date('d/m/Y',
                                strtotime($paydayDetail->start_date))}}
                                -
                                {{date('d/m/Y', strtotime($paydayDetail->end_date))}})</h4>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.salary-system.salary.calculation-list')}}">รอบเงินเดือนงวดปกติ</a>
                        </li>
                        <li class="breadcrumb-item active">รายการเงินเดือนงวดปกติ</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">

        <div class="container-fluid mt-0">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <a class="btn btn-primary float-right mb-2 ml-2"
                            href="{{route('groups.salary-system.salary.calculation-list.summary.download-report',['payday_detail_id' => $paydayDetail->id])}}">
                            <i class="fas fa-download mr-1"></i>
                            ดาวน์โหลด
                        </a>

                        @if (count($salarySummaries) == 0)
                        <a class="btn btn-success float-right mb-2"
                            href="{{route('groups.salary-system.salary.calculation-list.summary.finish',['payday_detail_id' => $paydayDetail->id])}}">
                            <i class="fas fa-check mr-1"></i>
                            ปิดงวด
                        </a>
                        @endif


                    </div>



                </div>
            </div>

            @if ($permission->show)
            <div class="row">

                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">พนักงาน</h3>
                            @if (count($users) !=0)
                            <div class="card-tools">
                                <div class="input-group input-group-sm">
                                    <input type="search" class="form-control " name="search_query" id="search_query"
                                        placeholder="ค้นหา">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-lg btn-default" id="btn-search">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endif

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <input type="text" id="paydayDetailId" value="{{$paydayDetail->id}}" hidden>
                                <div class="col-sm-12" id="table_container">
                                    <table class="table table-bordered table-striped dataTable dtr-inline">
                                        <thead>
                                            <tr>
                                                <th style="width: 8%">รหัสพนักงาน</th>
                                                <th style="width: 14%">ชื่อ-สกุล</th>
                                                <th style="width: 12%">แผนก</th>
                                                <th class="text-center" style="width: 8%">เงินเดือน</th>
                                                <th class="text-center" style="width: 8%">ล่วงเวลา</th>
                                                <th class="text-center" style="width: 8%">เบี้ยขยัน</th>
                                                <th class="text-center" style="width: 13%">เงินได้อื่นๆ</th>
                                                <th class="text-center" style="width: 13%">เงินหักอื่นๆ</th>
                                                <th class="text-center" style="width: 8%">ปกสค.</th>
                                                <th class="text-center" style="width: 10%">สุทธิ</th>
                                                <th class="text-right">ดาวน์โหลด</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                            @php
                                            $userSummary = $user->salarySummary($paydayDetail->id);
                                            $netIncome = round(str_replace(',', '', $userSummary['salary'])) +
                                            round(str_replace(',', '', $userSummary['overTimeCost'])) +
                                            round(str_replace(',', '', $userSummary['deligenceAllowance']));

                                            @endphp
                                            <tr>
                                                <td>
                                                    @if (count($user->getMissingDate($paydayDetail->id)) > 0)
                                                    <i class="fas fa-times-circle text-danger"></i>
                                                    @else
                                                    <i class="fas fa-check-circle text-success"></i>
                                                    @endif
                                                    {{ $user->employee_no }}
                                                </td>
                                                <td>{{ $user->prefix->name }}{{
                                                    $user->name }} {{
                                                    $user->lastname }}</td>
                                                <td>{{$user->company_department->name}}</td>
                                                <td class="text-center">{{$userSummary['salary']}}</td>
                                                <td class="text-center">{{$userSummary['overTimeCost']}}</td>
                                                <td class="text-center">{{$userSummary['deligenceAllowance']}}
                                                </td>

                                                <td class="text-left ">
                                                    @php
                                                    $totalIncome = 0;
                                                    @endphp
                                                    @foreach ($user->getSummaryIncomeDeductByUsers(1,$paydayDetail->id)
                                                    as $getIncomeDeductByUser)
                                                    @php
                                                    $totalIncome += $getIncomeDeductByUser->value;
                                                    @endphp
                                                    <li>{{$getIncomeDeductByUser->incomeDeduct->name}}
                                                        ({{$getIncomeDeductByUser->value}})</li>
                                                    @endforeach
                                                </td>
                                                <td class="text-left">
                                                    @php
                                                    $totalDeduct = 0;
                                                    @endphp
                                                    @foreach ($user->getSummaryIncomeDeductByUsers(2,$paydayDetail->id)
                                                    as $getIncomeDeductByUser)
                                                    @php
                                                    $totalDeduct += $getIncomeDeductByUser->value;
                                                    @endphp
                                                    <li>{{$getIncomeDeductByUser->incomeDeduct->name}}
                                                        ({{$getIncomeDeductByUser->value}})</li>
                                                    @endforeach
                                                </td>
                                                <td class="text-center">{{$userSummary['socialSecurityFivePercent']}}
                                                </td>
                                                @php
                                                $netIncome = $netIncome + $totalIncome - $totalDeduct -
                                                round(str_replace(',', '',
                                                $userSummary['socialSecurityFivePercent']));
                                                @endphp
                                                <td class="text-center">{{number_format($netIncome, 2)}}
                                                </td>
                                                <td class="text-right">
                                                    <a href="{{route('groups.salary-system.salary.calculation-list.summary.download-single',['user_id' => $user->id,'payday_detail_id' => $paydayDetail->id])}}"
                                                        class="btn btn-sm btn-primary"><i
                                                            class="fas fa-download"></i></a>
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

@push('scripts')

<script type="module" src="{{ asset('assets/js/helpers/salary-system/salary/calculation-list/summary/index.js?v=1') }}">
</script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        searchRoute: '{{ route('groups.salary-system.salary.calculation-list.summary.search') }}',        
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection