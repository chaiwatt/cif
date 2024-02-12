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
                    <h3 class="m-0">บันทึกเวลาและเงินได้ / เงินหัก: {{$user->prefix->name}}{{$user->name}}
                        {{$user->lastname}}
                    </h3>

                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.salary-system.salary.calculation-list.calculation',['id' => $paydayDetail->id])}}">รายการบันทึกเวลางวดปกติ</a>
                        </li>
                        <li class="breadcrumb-item active">{{$user->name}}</li>
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
                                    <a class="nav-link active" id="time-tab-tab" data-bs-toggle="tab" href="#time-tab"
                                        role="tab" aria-controls="time-tab" aria-selected="true">บันทึกเวลา</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="income-deducy-tab-tab" data-bs-toggle="tab"
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
                                            <div class="table-responsive">
                                                <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                                    <thead class="border-bottom">
                                                        <tr>
                                                            <th class="text-center" style="width: 10%">วันที่</th>
                                                            <th class="text-center" style="width: 10%">เวลารูดบัตร</th>
                                                            <th class="text-center" style="width: 10%">ชม.งาน</th>
                                                            <th class="text-center" style="width: 10%">มาสาย</th>
                                                            <th class="text-center" style="width: 10%">กลับก่อน</th>
                                                            <th class="text-center" style="width: 10%">ลา</th>
                                                            <th class="text-center" style="width: 10%">ขาดงาน</th>
                                                            <th class="text-center" style="width: 10%">ล่วงเวลา</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($workScheduleAssignmentUsers as $key =>
                                                        $workScheduleAssignmentUser)
                                                        @php
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
                                                            <td class="text-center">
                                                                @if($getWorkHour['leaveCount'] !== null)
                                                                {{$getWorkHour['leaveCount']['count']}}
                                                                ({{$getWorkHour['leaveCount']['leaveName']}})
                                                                @endif
                                                            </td>
                                                            <td class="text-center">{{$getWorkHour['absentCount']}}</td>
                                                            <td class="text-center">

                                                                @if ($getWorkHour['overTime'] != null)
                                                                {{$getWorkHour['overTime']['hourDifference']}}
                                                                @if ($getWorkHour['overTime']['isHoliday'] == true)
                                                                (ล่วงเวลา3.0)
                                                                @else
                                                                (ล่วงเวลา1.5)
                                                                @endif
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
                                <div class="tab-pane fade" id="income-deducy-tab" role="tabpanel"
                                    aria-labelledby="income-deducy-tab-tab">
                                    <div class=" table-responsive">
                                        <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                            @php
                                            $paymentDate = \Carbon\Carbon::parse($paydayDetail->payment_date);
                                            $endDate = \Carbon\Carbon::parse($paydayDetail->end_date);
                                            $currentDate = \Carbon\Carbon::now();
                                            $isExpire = true;
                                            if($paymentDate->gte($currentDate) && $currentDate->gte($endDate)){
                                            $isExpire = false;
                                            }
                                            @endphp
                                            <thead class="border-bottom">
                                                <tr>
                                                    <th>เงินเพิ่ม / เงินหัก</th>
                                                    <th>จำนวน</th>
                                                    <th>หน่วย</th>
                                                    <th class="text-end" style="width: 120px">ลบรายการ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($user->getIncomeDeductUsers($paydayDetail->id) as $key =>
                                                $incomeDeductByUser)
                                                <tr>
                                                    <td>{{$incomeDeductByUser->incomeDeduct->name}}
                                                    </td>
                                                    <td>{{$incomeDeductByUser->value}}</td>
                                                    <td>{{$incomeDeductByUser->incomeDeduct->unit->name}}</td>
                                                    <td class="text-end">
                                                        @if ($isExpire == false)
                                                        <a class="btn btn-action btn-delete btn-sm delete-income-deduct"
                                                            data-id="{{$incomeDeductByUser->id}}">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
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
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script type="module"
    src="{{asset('assets/js/helpers/salary-system/salary/calculation-list/calculation/information/index.js?v=1')}}">
</script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        deleteRoute: '{{ route('groups.salary-system.salary.calculation-extra-list.calculation.information.delete') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection