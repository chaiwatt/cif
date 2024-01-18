@extends('layouts.setting-dashboard')
@push('styles')

@endpush
@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">พนักงาน</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">พนักงาน</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">

        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>แผนก</label>
                                <select name="companyDepartment" id="companyDepartment"
                                    class="form-control select2 @error('companyDepartment') is-invalid @enderror"
                                    style="width: 100%;" multiple>
                                    @foreach ($companyDepartments as $companyDepartment)
                                    <option value="{{ $companyDepartment->id }}" {{
                                        old('companyDepartment')==$companyDepartment->id
                                        ?
                                        'selected' : '' }}>
                                        {{ $companyDepartment->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>ประเภทพนักงาน</label>
                                <select name="employeeType" id="employeeType"
                                    class="form-control select2 @error('employeeType') is-invalid @enderror"
                                    style="width: 100%;" multiple>
                                    @foreach ($employeeTypes as $employeeType)
                                    <option value="{{ $employeeType->id }}" {{ old('employeeType')==$employeeType->id
                                        ?
                                        'selected' : '' }}>
                                        {{ $employeeType->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>อื่น ๆ </label>
                                    <input type="text" name="search_string" id="search_string"
                                        value="{{old('search_string')}}" class="form-control"
                                        placeholder="รหัสพนักงาน,ชื่อ,สกุล,ตำแหน่ง,สัญชาติ,พาสพอร์ต,เลขที่บัตรประชาชน">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12 d-flex justify-content-end gap-2">
                            <button class="btn btn-outline-secondary d-flex gap-2 align-items-center" id="search_employee">
                                <i class="fas fa-search mr-1"></i>ค้นหา</button>
                            <a class="btn btn-primary d-flex gap-2 align-items-center" id="export_employee">
                                <i class="fas fa-file-excel mr-1"></i>ส่งออก
                                Excel</a>
                            <button class="btn btn-dark " id="setting_report_field"><i class="fas fa-cog"></i></button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">รายชื่อพนักงาน</h3>
                        </div>
                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12" id="table_container">
                                        <table class="table table-bordered table-striped dataTable dtr-inline"
                                            id="userTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>รหัสพนักงาน</th>
                                                    <th>ชื่อ-สกุล</th>
                                                    <th>แผนก</th>
                                                    <th>ตำแหน่ง</th>
                                                    <th>ประเภท</th>
                                                </tr>
                                            </thead>
                                            <tbody id="employee_tbody">
                                                @foreach ($users as $key => $user)
                                                <tr>
                                                    <td>{{($key + 1 + $users->perPage() * ($users->currentPage() - 1))}}
                                                    </td>
                                                    <td>{{$user->employee_no}}</td>
                                                    <td>{{$user->prefix->name}}{{$user->name}} {{$user->lastname}}</td>
                                                    <td>{{$user->company_department->name}}</td>
                                                    <td>{{$user->user_position->name}}</td>
                                                    <td>{{$user->employee_type->name}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{ $users->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-report-field">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12" id="search_field_table_container">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                        <button type="button" class="btn btn-primary" id="bntUpdateReportField">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')

{{-- <script type="module" src="{{asset('assets/js/helper/dashboard/report/report.js?v=1')}}"></script> --}}
<script type="module" src="{{asset('assets/js/helpers/setting/report/user/user.js?v=1')}}"></script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    $('.select2').select2();
    window.params = {
        searchRoute: '{{ route('setting.report.user.search') }}',
        exportRoute: '{{ route('setting.report.user.export') }}',
        getReportFieldRoute: '{{ route('setting.report.user.report-field') }}',
        updateReportFieldRoute: '{{ route('setting.report.user.update-report-field') }}',
        reportSearchRoute: '{{ route('setting.report.user.report-search') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>
@endpush
@endsection