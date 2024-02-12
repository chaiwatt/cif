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
                    <h3 class="m-0">{{$paydayDetail->month->name}} {{$paydayDetail->payday->year}}
                    </h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
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
                            <h4 class="card-title">รายงานรวม</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 table-responsive" id="table_container">
                                    <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                        <thead class="border-bottom">
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