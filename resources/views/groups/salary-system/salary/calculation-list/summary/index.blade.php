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
                    <h1 class="m-0">รายการเงินเดือนงวดปกติ
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
                                                <th style="width: 8%">รหัสพนักงาน</th>
                                                <th style="width: 15%">ชื่อ-สกุล</th>
                                                <th class="text-center" style="width: 10%">เงินเดือน</th>
                                                <th class="text-center" style="width: 10%">ล่วงเวลา</th>
                                                <th class="text-center" style="width: 10%">เบี้ยขยัน</th>
                                                <th class="text-center" style="width: 15%">เงินได้อื่นๆ</th>
                                                <th class="text-center" style="width: 15%">เงินหักอื่นๆ</th>
                                                <th class="text-center" style="width: 10%">เงินปกสค.</th>
                                                <th class="text-center" style="width: 10%">สุทธิ</th>
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
                                                    {{ $user->employee_no }}

                                                </td>
                                                <td>{{ $user->prefix->name }}{{
                                                    $user->name }} {{
                                                    $user->lastname }}</td>
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