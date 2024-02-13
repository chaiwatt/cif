@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="title-header">
                <div>
                    <h3 class="m-0">สายอนุมัติ: {{$approver->name}}</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.document-system.setting.approve-document')}}">สายอนุมัติ</a>
                        </li>
                        <li class="breadcrumb-item active">{{$approver->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="d-flex align-items-center gap-3 my-2">
                <div class="form-group">
                    <a class="btn btn-primary"
                        href="{{route('groups.document-system.setting.approve-document.assignment.create',['id' => $approver->id])}}">
                        <i class="fas fa-plus">
                        </i>
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
                </div>
                {{-- <div>
                    <span>หรือนำเข้าจากประเภท</span>
                </div>
                <div class="form-group ml-2 mr-2" style="width: 250px;">
                    <select name="employee_type" id="employee_type"
                        class="form-control select2 @error('employee_type') is-invalid @enderror" style="width: 100%;">
                        <option value="">==เลือกประเภท==</option>
                        <option value="1">รายเดือน</option>
                        <option value="2">รายวัน</option>
                    </select>
                </div> --}}

            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">รายการพนักงานใน {{$approver->name}}</h4>
                        </div>
                        <div>
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                                <thead class="border-bottom">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>รหัสพนักงาน</th>
                                                        <th>ชื่อ-สกุล</th>
                                                        <th>แผนก</th>
                                                        <th class="text-end">เพิ่มเติม</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($approver->users as $key => $user)
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{$user->employee_no}}</td>
                                                        <td>{{$user->name}} {{$user->lastname}}</td>
                                                        <td>{{$user->company_department->name}}</td>
                                                        <td class="text-end">
                                                            <form
                                                                action="{{ route('groups.document-system.setting.approve-document.assignment.delete', ['approver_id' => $approver->id, 'user_id' => $user->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-action btn-delete btn-sm" type="submit"><i
                                                                        class="fas fa-trash"></i></button>
                                                            </form>
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="cif-modal-body">
                    <input type="text" id="approverId" value="{{$approver->id}}" hidden>
                    <label for="employee-code" class="h5">รหัสพนักงานแถวละ 1 รายการ</label>
                    <textarea class="form-control" id="employee-code" rows="10"></textarea>
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
@push('scripts')
<script type="module" src="{{asset('assets/js/helpers/document-system/setting/approve-document/assignment.js?v=1')}}">
</script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        importEmployeeNoRoute: '{{ route('groups.document-system.setting.approve-document.assignment.import-employee-no') }}',
        importEmployeeNoFromDeptRoute: '{{ route('groups.document-system.setting.approve-document.assignment.import-employee-no-from-dept') }}',
       
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>
@endpush
@endsection