@extends('layouts.setting-dashboard')
@push('styles')

@endpush
@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="title-header">
                <div>
                    <h3 class="m-0">บทบาท</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">บทบาท</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">รายการบทบาท</h4>
                            <div class="d-flex gap-3">
                                <a class="btn btn-header" href="{{route('setting.access.role.create')}}">
                                    <i class="fas fa-plus">
                                    </i>
                                    เพิ่มบทบาท
                                </a>
                                {{-- <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <div id="searchWrapper" class="d-flex"></div>
                                    </div>
                                </div> --}}
                            </div>
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
                                                        <th>บทบาท</th>
                                                        <th>ผู้ใช้บทบาท</th>
                                                        <th class="text-center">กลุ่มงานมอบหมาย</th>
                                                        <th class="text-end">เพิ่มเติม</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($roles as $role)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{$role->name}}</td>

                                                        <td>
                                                            <ul class="mb-0">
                                                                @foreach ($role->users as $user)
                                                                <li style="padding: 5px;">{{$user->name}} {{$user->lastname}}<a
                                                                        class="text-danger ms-2 text-decoration-none"
                                                                        href="{{ route('setting.access.assignment.role.delete', ['roleId' => $role->id, 'userId' =>$user->id])}}">
                                                                        <i class="fas fa-times"
                                                                            style="font-size: smaller;"></i>
                                                                    </a>
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                        <td class="text-center">{{$role->role_group_jsons->count()}}</td>
                                                        <td class="text-end">
                                                            <a class="btn btn-action btn-user btn-sm" id="un_assignment_role_button"
                                                                data-role="{{$role->id}}">
                                                                <i class="fas fa-users"></i>
                                                            </a>
                                                            <a class="btn btn-action btn-links btn-sm"
                                                                href="{{ route('setting.access.assignment.group-module.view', ['id' => $role->id]) }}">
                                                                <i class="fas fa-link"></i>
                                                            </a>
                                                            <a class="btn btn-action btn-edit btn-sm"
                                                                href="{{ route('setting.access.role.view', ['id' => $role->id]) }}">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                            <a class="btn btn-action btn-delete btn-sm"
                                                                data-confirm='ลบบทบาท "{{$role->name}}" หรือไม่?' href="#"
                                                                data-id="{{$role->id}}"
                                                                data-delete-route="{{ route('setting.access.role.delete', ['id' => '__id__']) }}"
                                                                data-message="บทบาท">
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
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-users">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="cif-modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>เลือกผู้ใช้งาน</label>
                                    <select class="form-control select2" style="width: 100%;" multiple>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cif-modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="button" class="btn btn-primary" id="bntAssignUsersToRole">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="module" src="{{asset('assets/js/helpers/setting/access/role/role.js?v=1.1')}}"></script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>

<script>
    $('.select2').select2()
    window.params = {
        getUserRoute: '{{ route('api.get-user') }}',
        assignUserToRoleRoute: "{{ route('setting.access.assignment.role.store') }}",
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
   
</script>
@endpush
@endsection