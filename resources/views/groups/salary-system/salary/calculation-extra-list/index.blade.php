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
                    {{-- <ul class="mt-2">
                        @foreach ($paydayDetails as $paydayDetail)
                        <li>
                            <h4>{{$paydayDetail->payday->name}} (รอบเงินเดือน {{date('d/m/Y',
                                strtotime($paydayDetail->start_date))}}
                                -
                                {{date('d/m/Y', strtotime($paydayDetail->end_date))}})</h4>
                        </li>
                        @endforeach
                    </ul> --}}
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
                    <div class="col-12">
                        <div class="card card-primary card-outline card-tabs">

                            <div class="card-header p-0 pt-1 border-bottom-0">
                                <div class="card-tools mt-2">
                                    <div class="input-group input-group-sm mt-1" style="width: 150px;">
                                        <select name="year" id="year" class="form-control " style="width: 100%;">
                                            @php
                                            $currentYear = \Carbon\Carbon::now()->month;
                                            @endphp
                                            @foreach ($years as $year)
                                            <option value="{{ $year}}" @if ($year==$currentYear) selected @endif>
                                                {{ $year }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                    @foreach ($paydays->where('type',2) as $key => $payday)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}"
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
                                    @foreach ($paydays->where('type',2) as $key => $payday)
                                    <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}"
                                        id="custom-tabs-{{$payday->id}}" role="tabpanel"
                                        aria-labelledby="custom-tabs-{{$payday->id}}-tab">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ต้นงวด</th>
                                                    <th>ปลายงวด</th>
                                                    <th>การคำนวน</th>
                                                    <th style="width: 100px">เพิ่มเติม</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($payday->paydayDetails as $key => $paydayDetail)
                                                @php
                                                $startDate = \Carbon\Carbon::parse($paydayDetail->start_date);
                                                $endDate = \Carbon\Carbon::parse($paydayDetail->end_date);
                                                $currentMonth = \Carbon\Carbon::now()->month;
                                                $paymentDate = \Carbon\Carbon::parse($paydayDetail->payment_date);
                                                $currentDate = \Carbon\Carbon::now();
                                                @endphp

                                                @if ($startDate->month <= $currentMonth) <tr>
                                                    <td>{{ $startDate->format('d/m/Y') }}
                                                        @if ($paymentDate->gte($currentDate) &&
                                                        $currentDate->gte($endDate))
                                                        <i class="fas fa-fire-alt text-danger"></i>
                                                        @endif
                                                    </td>
                                                    <td>{{ $endDate->format('d/m/Y') }}</td>
                                                    <td>
                                                        @if ($currentDate->gte($paymentDate))

                                                        <span class="badge bg-gray">หมดเวลา</span>
                                                        @elseif($paymentDate->gte($currentDate) &&
                                                        $currentDate->gte($endDate))

                                                        <span class="badge bg-success">อยู่ในช่วงทำรายการ</span>
                                                        @else
                                                        <span class="badge bg-warning">รอบต่อไป</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{route('groups.salary-system.salary.calculation-extra-list.calculation',['id' => $paydayDetail->id])}}"
                                                            class="btn btn-sm btn-info"><i
                                                                class="fas fa-calculator"></i></a>
                                                        <a href="{{route('groups.salary-system.salary.calculation-extra-list.summary',['id' => $paydayDetail->id])}}"
                                                            class="btn btn-sm btn-success"><i
                                                                class="fas fa-chart-bar"></i></a>
                                                    </td>
                                                    </tr>
                                                    @endif
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