@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">รอบคำนวนเงินเดือน: {{$payday->name}}</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.salary-system.setting.payday')}}">รอบคำนวนเงินเดือน</a>
                        </li>
                        <li class="breadcrumb-item active">{{$payday->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($permission->create)
            <div class="d-flex align-items-center mt-2">
                <div class="form-group me-2">
                    <a class="btn btn-primary"
                        href="{{route('groups.salary-system.setting.payday.assignment-user.create',['id' => $payday->id])}}">
                        <i class="fas fa-plus mr-1">
                        </i>
                        เพิ่มพนักงาน
                    </a>
                </div>
                <div>
                    <span>หรือนำเข้าจากรหัสพนักงาน</span>
                </div>
                <div class="form-group my-2">
                    <a class="btn btn-primary " href="" id="import-employee-code">
                        <i class="fas fa-plus me-1"></i>
                        รหัสพนักงาน
                    </a>
                </div>
                <div>
                    <span>หรือนำเข้าจากแผนก</span>
                </div>
                <div class="form-group my-2" style="width: 250px;">
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
                </div>
                <div>
                    <span>หรือนำเข้าจากประเภท</span>
                </div>
                <div class="form-group my-2" style="width: 250px;">
                    <select name="employee_type" id="employee_type"
                        class="form-control select2 @error('employee_type') is-invalid @enderror" style="width: 100%;">
                        <option value="">==เลือกประเภท==</option>
                        <option value="1">รายเดือน</option>
                        <option value="2">รายวัน</option>
                    </select>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">รายการพนักงาน</h4>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="search_query" id="search_query"
                                        class="form-control" placeholder="ค้นหา">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <input name="paydayId" id="paydayId" value="{{$payday->id}}" type="text" hidden>
                                    <div class="col-sm-12" id="table_container">
                                        <table class="table table-bordered table-striped dataTable dtr-inline">
                                            <thead>
                                                <tr>
                                                    <th>รหัสพนักงาน</th>
                                                    <th>ชื่อ-สกุล</th>
                                                    <th>ประเภท</th>
                                                    <th>แผนก</th>
                                                    <th class="text-end">เพิ่มเติม</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $key => $user)
                                                <tr>
                                                    <td>{{$user->employee_no}}</td>
                                                    <td>{{$user->name}}
                                                        {{$user->lastname}}</td>
                                                    <td>{{$user->company_department->name}}</td>
                                                    <td>{{$user->employee_type->name}}</td>
                                                    <td class="text-end">
                                                        @if ($permission->delete)
                                                        <form
                                                            action="{{ route('groups.salary-system.setting.payday.assignment-user.delete', ['payday_id' => $payday->id, 'user_id' => $user->id]) }}"
                                                            method="POST">
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
                                        {{$users->links()}}
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
                <input type="text" id="paydayId" value="{{$payday->id}}" hidden>
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
                        <div class="col-sm-12 text-end">
                            <button type="button" class="btn btn-primary"
                                id="btn-import-employee-code">เพิ่มรายการ</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="module" src="{{asset('assets/js/helpers/salary-system/setting/payday/assignment-user/index.js?v=1')}}">
</script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        url: '{{ url('/') }}',
        importEmployeeNoRoute: '{{ route('groups.salary-system.setting.payday.assignment-user.import-employee-no') }}',
        importEmployeeNoFromDeptRoute: '{{ route('groups.salary-system.setting.payday.assignment-user.import-employee-no-from-dept') }}',
        importEmployeeNoFromUserTypeRoute: '{{ route('groups.salary-system.setting.payday.assignment-user.import-employee-no-from-user-type') }}',
        searchRoute: '{{ route('groups.salary-system.setting.payday.assignment-user.search') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection