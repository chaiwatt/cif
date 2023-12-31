@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-sm-6">
                    <h1 class="m-0">ตารางทำงาน: {{$workSchedule->name}} <span class="text-danger"
                            id="expire_message"></span></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.time-recording-system.schedulework.schedule.assignment',['id' => $workSchedule->id])}}">ตารางทำงาน</a>
                        </li>
                        <li class="breadcrumb-item active">{{$workSchedule->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($permission->create)
            {{-- <div id="add_user_wrapper"> --}}
                <div>
                    <div class="d-flex align-items-center mt-2">
                        <div class="form-group mr-2">
                            <a class="btn btn-primary "
                                href="{{ route('groups.time-recording-system.schedulework.schedule.assignment.user.create', ['workScheduleId' => $workSchedule->id, 'year' => $year, 'month' => $monthId]) }}">
                                <i class="fas fa-plus mr-1"></i>
                                เพิ่มพนักงาน
                            </a>
                        </div>
                        <div>
                            <span>หรือนำเข้าจากรหัสพนักงาน</span>
                        </div>
                        <div class="form-group ml-2 mr-2">
                            <a class="btn btn-primary " href="" id="import-employee-code">
                                <i class="fas fa-plus mr-1"></i>
                                รหัสพนักงาน
                            </a>
                        </div>
                        <div>
                            <span>หรือนำเข้าจากกลุ่มพนักงาน</span>
                        </div>
                        <div class="form-group ml-2 mr-2" style="width: 300px;">
                            <select name="userGroup" id="userGroup"
                                class="form-control select2 @error('userGroup') is-invalid @enderror"
                                style="width: 100%;">
                                <option value="">==เลือกกลุ่มพนักงาน==</option>
                                @foreach ($userGroups as $userGroup)
                                <option value="{{ $userGroup->id }}">
                                    {{ $userGroup->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div>
                            <span>หรือนำเข้าจากแผนก</span>
                        </div>
                        <div class="form-group ml-2 mr-2" style="width: 250px;">
                            <select name="company_department" id="company_department"
                                class="form-control select2 @error('company_department') is-invalid @enderror"
                                style="width: 100%;">
                                <option value="">==เลือกแผนก==</option>
                                @foreach ($companyDepartments as $companyDepartment)
                                <option value="{{ $companyDepartment->id }}">
                                    {{ $companyDepartment->name }}
                                </option>
                                @endforeach
                            </select>
                        </div> --}}
                    </div>
                </div>


                @endif
                <div class="row mt-2">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">รายการพนักงานใน {{$workSchedule->name}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="dataTables_wrapper dt-bootstrap4">
                                    <div class="row">
                                        <div class="col-sm-12" id="table_content">
                                            <table class="table table-bordered table-striped dataTable dtr-inline">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>รหัสพนักงาน</th>
                                                        <th>ชื่อ-สกุล</th>
                                                        <th>แผนก</th>
                                                        <th class="text-right">เพิ่มเติม</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($users as $key => $user)
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{$user->employee_no}}</td>
                                                        <td>{{$user->name}} {{$user->lastname}}</td>
                                                        <td>{{$user->company_department->name}}</td>
                                                        <td class="text-right">
                                                            @if ($permission->delete)
                                                            <form
                                                                action="{{ route('groups.time-recording-system.schedulework.schedule.assignment.user.delete', ['workScheduleId' => $workSchedule->id, 'year' => $year, 'month' => $monthId, 'userId' => $user->id]) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-danger btn-sm" type="submit"><i
                                                                        class="fas fa-trash"></i></button>
                                                            </form>
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
            </div>
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
    @push('scripts')
    <script type="module"
        src="{{asset('assets/js/helpers/time-recording-system/schedule/assignment/assignment.js?v=1')}}">
    </script>
    <script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
    <script>
        $('.select2').select2()
    window.params = {
        importUserGroupRoute: '{{ route('groups.time-recording-system.schedulework.schedule.assignment.user.import-user-group') }}',
        importEmployeeNoRoute: '{{ route('groups.time-recording-system.schedulework.schedule.assignment.user.import-employee-no') }}',
        importEmployeeNoFromDeptRoute: '{{ route('groups.time-recording-system.schedulework.schedule.assignment.user.import-employee-no-from-dept') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
    </script>
    @endpush
    @endsection