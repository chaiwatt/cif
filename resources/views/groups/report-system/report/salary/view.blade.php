@extends('layouts.dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/loading.css?v=1.0') }}">
@endpush
<div>
    @include('layouts.partial.loading')
    <div>
        <div class="container-fluid">
            <div class="row mb-2">
                <div>
                    <h3 class="m-0">{{$paydayDetail->month->name}} {{$paydayDetail->payday->year}}</h3>
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
                        <div class="card-body py-0">
                            <div class="row">
                                <div class="col-sm-12 table-responsive" id="table_container">
                                    <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                        <thead>
                                            <tr>
                                                <th>แผนก</th>
                                                {{-- <th class="text-center">พนักงาน</th> --}}
                                                <th class="text-center">เงินเดือน</th>
                                                <th class="text-center">ค่าล่วงเวลา</th>
                                                <th class="text-center">เบี้ยขยัน</th>
                                                <th class="text-center">รายได้อื่นๆ</th>
                                                <th class="text-center">หักอื่นๆ</th>
                                                <th class="text-center">ประกันสังคม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($companyDepartments as $companyDepartment)
                                            @php
                                            $salarySummary = $companyDepartment->salarySummary($paydayDetail->id);

                                            if ($salarySummary) {
                                            $sum_salary = $salarySummary->sum_salary == 0 ? '' :
                                            number_format($salarySummary->sum_salary,2);

                                            $sum_overtime = $salarySummary->sum_overtime == 0 ? '' :
                                            number_format($salarySummary->sum_overtime,2);

                                            $sum_allowance_diligence = $salarySummary->sum_allowance_diligence == 0 ? ''
                                            :
                                            number_format($salarySummary->sum_allowance_diligence,2);

                                            $sum_income = $salarySummary->sum_income == 0 ? '' :
                                            number_format($salarySummary->sum_income,2);

                                            $sum_deduct = $salarySummary->sum_deduct == 0 ? '' :
                                            number_format($salarySummary->sum_deduct,2);

                                            $sum_social_security = $salarySummary->sum_social_security == 0 ? '' :
                                            number_format($salarySummary->sum_social_security,2);
                                            }

                                            @endphp
                                            <tr>
                                                <td>{{$companyDepartment->name}}</td>
                                                {{-- <td class="text-center">{{$employee}}</td> --}}
                                                <td class="text-center">{{@$sum_salary}}</td>
                                                <td class="text-center">{{@$sum_overtime}}</td>
                                                <td class="text-center">{{@$sum_allowance_diligence}}</td>
                                                <td class="text-center">{{@$sum_income}}</td>
                                                <td class="text-center">{{@$sum_deduct}}</td>
                                                <td class="text-center">{{@$sum_social_security}}</td>
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