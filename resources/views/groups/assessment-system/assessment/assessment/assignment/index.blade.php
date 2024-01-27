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
                    <h3 class="m-0">การประเมิน: {{$assessmentGroup->name}}</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.assessment-system.assessment.assessment')}}">การประเมิน</a>
                        </li>
                        <li class="breadcrumb-item active">{{$assessmentGroup->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($permission->show)
            <div class="row">
                <input type="text" value="{{$assessmentGroup->id}}" id="assessmentGroupId" hidden>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">รายชื่อพนักงานเข้ารับประเมิน</h4>
                            <a class="btn btn-header" id="import-employee-code" href="">
                                <i class="fas fa-plus"></i>
                                เพิ่มพนักงาน
                            </a>
                        </div>
                        <div class="card-body py-0">
                            <div class="row">
                                <div class="col-sm-12 table-responsive" id="table_container">
                                    <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                        <thead class="border-bottom">
                                            <tr>
                                                <th>รหัสพนักงาน</th>
                                                <th>ชื่อ-สกุล</th>
                                                <th>แผนก</th>
                                                <th class="text-end" style="width: 120px">ประเมิน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                            <td>{{$user->employee_no}}</td>
                                            <td>{{$user->name}} {{$user->lastname}}</td>
                                            <td>{{$user->company_department->name}}</td>
                                            <td class="text-end">
                                                <a class="btn btn-action btn-sm" style="--bs-btn-color: #0BA5EC; --bs-btn-color-hover: #0086C9;"
                                                href="{{route('groups.assessment-system.assessment.assessment.assignment.scoring',['user_id' => $user->id,'id' => $assessmentGroup->id])}}">
                                                <i class="fas fa-clipboard-list"></i>
                                                </a>
                                                <a class="btn btn-action btn-sm" style="--bs-btn-color: #12B76A; --bs-btn-color-hover: #039855;"
                                                    href="{{route('groups.assessment-system.assessment.assessment.assignment.summary',['user_id' => $user->id,'id' => $assessmentGroup->id])}}">
                                                    <i class="fas fa-award"></i>
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
    <div class="modal fade" id="modal-import-employee-code">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="cif-modal-body">
                    <label for="employee-code" class="h5">
                        รหัสพนักงานแถวละ 1 รายการ
                    </label>
                    <textarea class="form-control" id="employee-code" rows="12"></textarea>
                </div>
                <div class="cif-modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="width: 160px;">ยกเลิก</button>
                    <button type="button" class="btn btn-primary"
                        id="btn-import-employee-code" style="width: 160px;">เพิ่มรายการ</button>
                </div>
            </div>
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

<script type="module"
    src="{{ asset('assets/js/helpers/assessment-system/assessment/assessment/assignment/index.js?v=1') }}">
</script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        importUserGroupRoute: '{{ route('groups.assessment-system.assessment.assessment.assignment.import-user') }}',       
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection