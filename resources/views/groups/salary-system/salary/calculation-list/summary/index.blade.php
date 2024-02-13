@extends('layouts.dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/loading.css?v=1.0') }}">
@endpush
<div>
    @include('layouts.partial.loading')
    <div>
        <div class="container-fluid">
            <div class="title-header">
                <div>
                    <h3 class="m-0">รายการเงินเดือนงวดปกติ @if (count($salarySummaries) != 0)
                        <span class="text-danger">(ปิดงวด)</span>
                        @endif
                    </h3>
                    <ul class="mt-2">
                        <li>
                            <h4>{{$paydayDetail->payday->name}} (รอบเงินเดือน {{date('d/m/Y',
                                strtotime($paydayDetail->start_date))}}
                                -
                                {{date('d/m/Y', strtotime($paydayDetail->end_date))}})</h4>
                        </li>
                    </ul>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
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
            @if ($permission->show)
            <div class="row">

                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">พนักงาน</h4>
                            <div class="d-flex gap-2">
                                    <a class="btn btn-header"
                                    href="{{route('groups.salary-system.salary.calculation-list.summary.download-report',['payday_detail_id' => $paydayDetail->id])}}">
                                    <i class="fas fa-download"></i>
                                    ดาวน์โหลด
                                </a>
                                @if (count($salarySummaries) == 0)
                                <a class="btn btn-header"
                                    href="{{route('groups.salary-system.salary.calculation-list.summary.finish',['payday_detail_id' => $paydayDetail->id])}}">
                                    <i class="fas fa-check"></i>
                                    ปิดงวด
                                </a>
                                @endif
                                @if (count($users) !=0)
                                <div class="card-tools">
                                    <div class="input-group input-group-sm">
                                        <input type="search" class="form-control " name="search_query" id="search_query"
                                            placeholder="ค้นหา">
                                        <div class="input-group-append">
                                            <button type="button" class="btn" id="btn-search">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                        </div>
                        <div>
                            <div class="row">
                                <input type="text" id="paydayDetailId" value="{{$paydayDetail->id}}" hidden>
                                <div class="col-sm-12" id="table_container">
                                    <div class="table-responsive">
                                        <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                            <thead class="border-bottom">
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
                                                    <th class="text-end">ดาวน์โหลด</th>
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

                                                    <td class="text-start ">
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
                                                    <td class="text-start">
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
                                                    <td class="text-end">
                                                        <a href="{{route('groups.salary-system.salary.calculation-list.summary.download-single',['user_id' => $user->id,'payday_detail_id' => $paydayDetail->id])}}"
                                                            class="btn btn-sm btn-action btn-links"><i
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