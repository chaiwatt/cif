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
                    <h1 class="m-0">{{$paydayDetail->month->name}} {{$paydayDetail->payday->year}}
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('groups.report-system.report.salary')}}">รายงาน</a>
                        </li>
                        <li class="breadcrumb-item active">{{$paydayDetail->month->name}}
                            {{$paydayDetail->payday->year}}</li>
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
                                                <th>แผนก</th>
                                                {{-- <th class="text-center">พนักงาน</th> --}}
                                                <th class="text-center">ขาดงาน</th>
                                                <th class="text-center">ลางาน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($companyDepartments as $companyDepartment)
                                            @php
                                            $salarySummary = $companyDepartment->salarySummary($paydayDetail->id);

                                            if ($salarySummary) {
                                            $sum_leave = $salarySummary->sum_leave == 0 ? '' :
                                            $salarySummary->sum_leave;

                                            $sum_absence = $salarySummary->sum_absence == 0 ? '' :
                                            $salarySummary->sum_absence;

                                            }

                                            @endphp
                                            <tr>
                                                <td>{{$companyDepartment->name}}</td>
                                                {{-- <td class="text-center">{{$employee}}</td> --}}
                                                <td class="text-center">{{@$sum_leave}}</td>
                                                <td class="text-center">{{@$sum_absence}}</td>
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