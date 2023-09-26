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
                    <h1 class="m-0">การประเมิน: {{$assessmentGroup->name}}
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.assessment-system.assessment.assessment')}}">การประเมิน</a>
                        </li>
                        <li class="breadcrumb-item active">การประเมิน</li>
                    </ol>
                </div>
            </div>

            <a class="btn btn-primary mb-2" id="import-employee-code" href="">
                <i class="fas fa-plus mr-1"></i>
                เพิ่มพนักงาน
            </a>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($permission->show)
            <div class="row">
                <input type="text" value="{{$assessmentGroup->id}}" id="assessmentGroupId" hidden>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">รายการพนักงาน</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12" id="table_container">
                                    <table class="table table-bordered table-striped dataTable dtr-inline">
                                        <thead>
                                            <tr>
                                                <th>รหัสพนักงาน</th>
                                                <th>ชื่อ-สกุล</th>
                                                <th>แผนก</th>
                                                <th class="text-right" style="width: 120px">ประเมิน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                            <td>{{$user->employee_no}}</td>
                                            <td>{{$user->name}} {{$user->lastname}}</td>
                                            <td>{{$user->company_department->name}}</td>
                                            <td class="text-right">
                                                <a class="btn btn-success btn-sm"
                                                    href="{{route('groups.assessment-system.assessment.assessment.assignment.summary',['user_id' => $user->id,'id' => $assessmentGroup->id])}}">
                                                    <i class="fas fa-award"></i>
                                                </a>
                                                <a class="btn btn-info btn-sm"
                                                    href="{{route('groups.assessment-system.assessment.assessment.assignment.scoring',['user_id' => $user->id,'id' => $assessmentGroup->id])}}">
                                                    <i class="fas fa-user"></i>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
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