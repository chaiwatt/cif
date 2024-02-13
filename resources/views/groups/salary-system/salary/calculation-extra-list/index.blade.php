@extends('layouts.dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/loading.css?v=1.0') }}">
@endpush
<div>
    @include('layouts.partial.loading')
    <div class="content-header">
        <div class="container-fluid">
            <div class="title-header">
                <div>
                    <h3 class="m-0">รอบเงินเดือนงวดพิเศษ</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a>
                        </li>
                        <li class="breadcrumb-item active">รอบเงินเดือนงวดพิเศษ</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($permission->show)
            <div class="row">
                <div class="col-12" id="content_wrapper">

                    <div class="card card-tabs pe-2">
                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                @foreach ($paydays->where('type',2) as $key => $payday)
                                <li class="nav-item">
                                    <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                                        id="custom-tabs-{{$payday->id}}-tab" data-bs-toggle="tab"
                                        href="#custom-tabs-{{$payday->id}}" role="tab"
                                        aria-controls="custom-tabs-{{$payday->id}}"
                                        aria-selected="true">{{$payday->name}}</a>
                                </li>
                                @endforeach
                                <li class="ms-auto my-2">
                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <select name="year" id="year" class="form-control select2" style="width: 100%;">
                                                @if (count($years) >= 1)     
                                                    @foreach ($years as $year)
                                                    <option value="{{$year}}" {{ $year==date('Y') ? 'selected' : '' }}>{{$year}}
                                                    </option>
                                                    @endforeach
                                                @else
                                                    <option value="" disabled selected>ยังไม่มีข้อมูล</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        <div>
                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                @foreach ($paydays->where('type',2) as $key => $payday)
                                <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}"
                                    id="custom-tabs-{{$payday->id}}" role="tabpanel"
                                    aria-labelledby="custom-tabs-{{$payday->id}}-tab">
                                    <div class="table-responsive">
                                        <table class="table table-borderless text-nowrap">
                                            <thead class="border-bottom">
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
                                                        <span class="badge bg-gray rouned-3" style="padding: 8px 12px">หมดเวลา</span>
                                                        @elseif($paymentDate->gte($currentDate) &&
                                                        $currentDate->gte($endDate))
                                                        <span class="badge bg-success rouned-3" style="padding: 8px 12px">อยู่ในช่วงทำรายการ</span>
                                                        @else
                                                        <span class="badge bg-warning rouned-3" style="padding: 8px 12px">รอบต่อไป</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{route('groups.salary-system.salary.calculation-extra-list.calculation',['id' => $paydayDetail->id])}}"
                                                            class="btn btn-action btn-calculator">
                                                            <i class="fas fa-calculator"></i>
                                                        </a>
                                                        <a href="{{route('groups.salary-system.salary.calculation-extra-list.summary',['id' => $paydayDetail->id])}}"
                                                            class="btn btn-action btn-edit">
                                                            <i class="fas fa-chart-bar"></i>
                                                        </a>
                                                    </td>
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                            </tbody>
                                        </table>
                                    </div>
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

<script type="module" src="{{ asset('assets/js/helpers/salary-system/salary/calculation-extra-list/index.js?v=1') }}">
</script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        searchRoute: '{{ route('groups.salary-system.salary.calculation-extra-list.search') }}',        
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
    $('.select2').select2()
</script>

@endpush
@endsection