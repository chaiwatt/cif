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
                    <h1 class="m-0">เกณฑ์การประเมิน
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a>
                        </li>
                        <li class="breadcrumb-item active">เกณฑ์การประเมิน</li>
                    </ol>
                </div>
            </div>

            <a class="btn btn-primary mb-2" id="btn-show-modal-income-deduct-assignment"
                href="{{route('groups.assessment-system.setting.criteria.create')}}">
                <i class="fas fa-plus mr-1"></i>
                เพิ่มเกณฑ์การประเมิน
            </a>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($permission->show)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">เกณฑ์การประเมิน</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12" id="table_container">
                                    <table class="table table-bordered table-striped dataTable dtr-inline">
                                        <thead>
                                            <tr>
                                                <th>เกณฑ์การประเมิน</th>
                                                <th>รายละเอียด</th>
                                                <th class="text-right" style="width: 120px">เพิ่มเติม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($assessmentCriterias as $assessmentCriteria)
                                            <td>{{$assessmentCriteria->name}}</td>
                                            <td>{{$assessmentCriteria->description}}</td>
                                            <td class="text-right">
                                                <a class="btn btn-info btn-sm"
                                                    href="{{route('groups.assessment-system.setting.criteria.view',['id' => $assessmentCriteria->id])}}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <a class="btn btn-danger btn-sm"
                                                    data-confirm='ลบเกณฑ์การประเมิน "{{$assessmentCriteria->name}}" หรือไม่?'
                                                    href="#" data-id="{{$assessmentCriteria->id}}"
                                                    data-delete-route="{{ route('groups.assessment-system.setting.criteria.delete', ['id' => '__id__']) }}"
                                                    data-message="เกณฑ์การประเมิน">
                                                    <i class="fas fa-trash"></i>
                                                </a>
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

{{-- <script type="module"
    src="{{ asset('assets/js/helpers/salary-system/salary/calculation-list/calculation/index.js?v=1') }}">
</script> --}}
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
{{-- <script>
    window.params = {
        importIncomeDeductRoute: '{{ route('groups.salary-system.salary.calculation-list.calculation.import-income-deduct') }}',        
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script> --}}

@endpush
@endsection