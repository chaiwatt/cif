@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="title-header">
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
            <div class="d-flex align-items-center mt-2 flex-wrap gap-3">
                <div class="d-flex gap-3 text-nowrap align-items-center me-2">
                    <a class="btn btn-primary"
                        href="{{route('groups.salary-system.setting.payday.assignment-user.create',['id' => $payday->id])}}">
                        <i class="fas fa-plus me-1">
                        </i>
                        เพิ่มพนักงาน
                    </a>
                    <span>หรือนำเข้าจากรหัสพนักงาน</span>
                    <a class="btn btn-primary " href="" id="import-employee-code">
                        <i class="fas fa-plus me-1"></i>
                        รหัสพนักงาน
                    </a>
                </div>
                <div class="d-flex gap-3 text-nowrap align-items-center my-2" style="width: 300px;">
                    <span>หรือนำเข้าจากแผนก</span>
                    <select name="company_department" id="company_department"
                        class="form-control select2 @error('company_department') is-invalid @enderror"
                        style="flex: 0 0 150px;">
                        <option value="">==เลือกแผนก==</option>
                        @foreach ($companyDepartments as $companyDepartment)
                        <option value="{{ $companyDepartment->id }}">
                            {{ $companyDepartment->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex gap-3 text-nowrap align-items-center my-2" style="width: 250px;">
                    <span>หรือนำเข้าจากประเภท</span>
                    <select name="employee_type" id="employee_type"
                        class="form-control select2 @error('employee_type') is-invalid @enderror" style="flex: 0 0 150px;">
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
                        <div class="card-header">
                            <h4 class="card-title">รายการพนักงาน</h4>
                            <div class="card-tools search">
                                <input type="text" name="search_query" id="search_query"
                                    class="form-control" placeholder="ค้นหา">
                                    <label for="search_query">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="23" viewBox="0 0 22 23" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.0833 4.39585C6.66608 4.39585 3.89584 7.16609 3.89584 10.5834C3.89584 14.0006 6.66608 16.7709 10.0833 16.7709C11.7446 16.7709 13.2529 16.1162 14.3644 15.0507C14.3915 15.0167 14.4208 14.9838 14.4523 14.9523C14.4838 14.9208 14.5167 14.8915 14.5507 14.8644C15.6162 13.7529 16.2708 12.2446 16.2708 10.5834C16.2708 7.16609 13.5006 4.39585 10.0833 4.39585ZM16.8346 15.7141C17.9188 14.2897 18.5625 12.5117 18.5625 10.5834C18.5625 5.90044 14.7663 2.10419 10.0833 2.10419C5.40042 2.10419 1.60417 5.90044 1.60417 10.5834C1.60417 15.2663 5.40042 19.0625 10.0833 19.0625C12.0117 19.0625 13.7896 18.4188 15.2141 17.3346L18.4398 20.5602C18.8873 21.0077 19.6128 21.0077 20.0602 20.5602C20.5077 20.1128 20.5077 19.3873 20.0602 18.9398L16.8346 15.7141Z" fill="#475467"/>
                                          </svg>
                                    </label>
                            </div>
                        </div>
                        <div>
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <input name="paydayId" id="paydayId" value="{{$payday->id}}" type="text" hidden>
                                    <div class="col-sm-12" id="table_container">
                                        <div class="table-responsive">
                                            <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                                <thead class="border-bottom">
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
                                                                <button class="btn btn-action btn-delete btn-sm" type="submit">
                                                                    <i class="fas fa-trash"></i></button>
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
    </div>
    <div class="modal fade" id="modal-import-employee-code">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 600px;">
            <div class="modal-content" style="height: 600px">
                <input type="text" id="paydayId" value="{{$payday->id}}" hidden>
                <div class="cif-modal-body">
                    <label for="employee-code" class="h5">รหัสพนักงานแถวละ 1 รายการ</label>
                    <textarea class="form-control" id="employee-code" rows="18"></textarea>
                </div>
                    <div class="cif-modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="button" class="btn btn-primary"
                            id="btn-import-employee-code">เพิ่มรายการ</button>
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