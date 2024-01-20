@extends('layouts.dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/loading.css?v=1.0') }}">
@endpush
<div>
    @include('layouts.partial.loading')
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">คะแนนเกณฑ์การประเมิน</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a>
                        </li>
                        <li class="breadcrumb-item active">คะแนนเกณฑ์การประเมิน</li>
                    </ol>
                </div>
            </div>

            <a class="btn btn-primary mb-2" id="btn-show-modal-income-deduct-assignment"
                href="{{route('groups.assessment-system.setting.score.create')}}">
                <i class="fas fa-plus me-1"></i>
                เพิ่มคะแนนเกณฑ์การประเมิน
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
                            <h4 class="card-title">คะแนนเกณฑ์การประเมิน</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12" id="table_container">
                                    <table class="table table-bordered table-striped dataTable dtr-inline">
                                        <thead>
                                            <tr>
                                                <th>คะแนนเกณฑ์การประเมิน</th>
                                                <th class="text-end" style="width: 120px">เพิ่มเติม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($assessmentScores as $assessmentScore)
                                            <td>{{$assessmentScore->score}}</td>
                                            <td class="text-end">
                                                <a class="btn btn-primary btn-sm"
                                                    href="{{route('groups.assessment-system.setting.score.view',['id' => $assessmentScore->id])}}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <a class="btn btn-danger btn-sm"
                                                    data-confirm='ลบคะแนนเกณฑ์การประเมิน "{{$assessmentScore->score}}" หรือไม่?'
                                                    href="#" data-id="{{$assessmentScore->id}}"
                                                    data-delete-route="{{ route('groups.assessment-system.setting.score.delete', ['id' => '__id__']) }}"
                                                    data-message="คะแนนเกณฑ์การประเมิน">
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
{{-- <div class="modal-footer justify-content-between">
    {{-- <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
    <button type="button" class="btn btn-primary" id="bntUpdateReportField">ต่อไป</button>
</div>
</div>
</div>
</div>
</div> --}}
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