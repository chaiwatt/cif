@extends('layouts.dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/loading.css?v=1.0') }}">
@endpush
<div>
    @include('layouts.partial.loading')
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">รายการเงินเดือนงวดพิเศษ</h3>
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
                                href="{{route('groups.salary-system.salary.calculation-extra-list')}}">รอบเงินเดือนงวดพิเศษ</a>
                        </li>
                        <li class="breadcrumb-item active">รายการเงินเดือนงวดพิเศษ</li>
                    </ol>
                </div>
            </div>
            <input type="text" id="paydayDetailId" value="{{$paydayDetail->id}}" hidden>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($permission->show)
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group text-end">
                      
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">พนักงาน</h3>
                                <a class="btn btn-header"
                                    href="{{route('groups.salary-system.salary.calculation-extra-list.download-report',['payday_detail_id' => $paydayDetail->id])}}">
                                    <i class="fas fa-download"></i>
                                    ดาวน์โหลด
                                </a>
                            @if (count($users) !=0)
                            <div class="card-tools">
                                {{-- <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="search_query" id="search_query"
                                        class="form-control float-right" placeholder="ค้นหา">
                                </div> --}}
                            </div>
                            @endif

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 table-responsive" id="table_container">
                                    <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                        <thead class="border-bottom">
                                            <tr>
                                                <th style="width: 10%">รหัสพนักงาน</th>
                                                <th style="width: 20%">ชื่อ-สกุล</th>
                                                <th class="text-center" style="width: 20%">OT ส่วนเกิน</th>
                                                <th class="text-center" style="width: 20%">OT วันหยุดประจำสัปดาห์
                                                </th>
                                                <th class="text-center" style="width: 20%">OT วันหยุดประจำปี</th>
                                                <th class="text-center" style="width: 10%">รวม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                            @php
                                            $userSummary = $user->getExtraOvertime($paydayDetail->id);
                                            // $summary = $user->salarySummary($paydayDetail->id);
                                            @endphp
                                            @php
                                            $exceedOvertimeCost = $userSummary['exceedOvertimeCost'];
                                            $holidayOvertimeCost = $userSummary['holidayOvertimeCost'];
                                            $traditionalHolidayOvertimeCost
                                            =$userSummary['traditionalHolidayOvertimeCost'];
                                            @endphp
                                            @if (floatval($exceedOvertimeCost) != 0 || floatval($holidayOvertimeCost) !=
                                            0 ||
                                            floatval($traditionalHolidayOvertimeCost) != 0)
                                            <tr>
                                                <td>
                                                    {{ $user->employee_no }}

                                                </td>
                                                <td>{{ $user->prefix->name }}{{
                                                    $user->name }} {{
                                                    $user->lastname }}</td>
                                                <td class="text-center">{{
                                                    number_format(round($exceedOvertimeCost, 0),
                                                    2)}}
                                                </td>
                                                <td class="text-center">{{ number_format(round($holidayOvertimeCost, 0),
                                                    2)}}</td>
                                                <td class="text-center">{{
                                                    number_format(round($traditionalHolidayOvertimeCost, 0), 2)}}</td>
                                                <td class="text-center">{{ number_format(round($exceedOvertimeCost +
                                                    $holidayOvertimeCost +
                                                    $traditionalHolidayOvertimeCost, 0), 2)}}
                                                </td>

                                            </tr>
                                            @endif

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
    <div class="modal fade" id="modal-income-deduct-assignment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>เงินได้ / เงินหัก <span class="fw-bold text-danger">*</span></label>
                                <select id="incomeDeduct" class="form-control select2 " style="width: 100%;">
                                    <option value="">==เลือกรายการเงินได้ / เงินหัก==</option>
                                    @foreach ($incomeDeducts as $incomeDeduct)
                                    <option value="{{ $incomeDeduct->id }}">
                                        {{ $incomeDeduct->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="employee-code">รหัสพนักงานแถวละ 1 รายการ</label>
                                <textarea class="form-control" id="employee-code" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-end">
                            <button type="button" class="btn btn-primary" id="btn-import-employee-code">เพิ่มรายการ</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@push('scripts')

<script type="module"
    src="{{ asset('assets/js/helpers/salary-system/salary/calculation-list/calculation/index.js?v=1') }}">
</script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        importIncomeDeductRoute: '{{ route('groups.salary-system.salary.calculation-list.calculation.import-income-deduct') }}',        
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection