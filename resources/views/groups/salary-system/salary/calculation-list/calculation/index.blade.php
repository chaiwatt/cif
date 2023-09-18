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
                                href="{{route('groups.time-recording-system.schedulework.time-recording')}}">ตารางทำงาน</a>
                        </li>
                        <li class="breadcrumb-item active">นำเข้าไฟล์เวลา</li>
                    </ol>
                </div>
            </div>
            @php
            use Carbon\Carbon;
            $paymentDate = Carbon::parse($paydayDetail->payment_date);
            $endDate = Carbon::parse($paydayDetail->end_date);
            $currentDate = Carbon::now();
            @endphp

            @if ($paymentDate->gte($currentDate) && $currentDate->gte($endDate))
            <a class="btn btn-primary mb-2" id="btn-show-modal-income-deduct-assignment">
                <i class="fas fa-plus mr-1"></i>
                เพิ่มเงินได้เงินหัก
            </a>
            @endif

            <input type="text" id="paydayDetailId" value="{{$paydayDetail->id}}" hidden>
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
                                                <th class="text-center">OT(ชม.)</th>
                                                {{-- <th class="text-center">เบี้ยขยัน</th> --}}
                                                <th class="text-right" style="width: 120px">เพิ่มเติม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                            @php
                                            $userSummary = $user->salarySummary($paydayDetail->id);
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
                                                <td class="text-center">{{$userSummary['workHour']}}</td>
                                                <td class="text-center">{{$userSummary['lateHour']}}</td>
                                                <td class="text-center">{{$userSummary['earlyHour']}}</td>
                                                <td class="text-center">{{$userSummary['leaveCountSum']}}</td>
                                                <td class="text-center">{{$userSummary['absentCountSum']}}</td>
                                                <td class="text-center">{{$userSummary['overTime']}}</td>
                                                {{-- <td class="text-center">{{$userSummary['deligenceAllowance']}} --}}
                                                </td>
                                                <td class="text-right">

                                                    <a class="btn btn-sm btn-info btn-user" data-id="{{$user->id}}"
                                                        data-startDate="{{$paydayDetail->start_date}}"
                                                        data-endDate="{{$paydayDetail->end_date}}"
                                                        href="{{route('groups.salary-system.salary.calculation-extra-list.calculation.information',['start_date' => $paydayDetail->start_date,'end_date' => $paydayDetail->end_date,'user_id' => $user->id,'payday_detail_id' => $paydayDetail->id] )}}"><i
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
    <div class="modal fade" id="modal-income-deduct-assignment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>เงินได้ / เงินหัก<span class="small text-danger">*</span></label>
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
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-primary float-right"
                                id="btn-import-employee-code">เพิ่มรายการ</button>
                        </div>
                    </div>
                </div>
            </div>
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