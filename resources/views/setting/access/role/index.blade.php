@extends('layouts.setting-dashboard')
@push('styles')

@endpush
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">บทบาท</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">บทบาท</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <a class="btn btn-primary mb-2" href="{{route('setting.access.role.create')}}">
                <i class="fas fa-plus mr-1">
                </i>
                เพิ่มบทบาท
            </a>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">รายการบทบาท</h3>
                            <div class="card-tools mr-1">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <div id="searchWrapper" class="d-flex"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-bordered table-striped dataTable dtr-inline">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>บทบาท</th>
                                                    <th>ผู้ใช้บทบาท</th>
                                                    <th class="text-center">กลุ่มงานมอบหมาย</th>
                                                    <th class="text-right">เพิ่มเติม</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($roles as $role)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{$role->name}}</td>

                                                    <td>
                                                        <ul>
                                                            @foreach ($role->users as $user)
                                                            <li style="padding: 5px;">
                                                                {{$user->name}} {{$user->lastname}}<a
                                                                    class="text-danger ml-2"
                                                                    href="{{ route('setting.access.assignment.role.delete', ['roleId' => $role->id, 'userId' =>$user->id])}}"><i
                                                                        class="fas fa-times"
                                                                        style="font-size: smaller;"></i>
                                                                </a>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td class="text-center">{{$role->role_group_jsons->count()}}</td>
                                                    <td class="text-right">
                                                        <a class="btn btn-success btn-sm" id="un_assignment_role_button"
                                                            data-role="{{$role->id}}">
                                                            <i class="fas fa-users"></i>
                                                        </a>
                                                        <a class="btn btn-primary btn-sm"
                                                            href="{{ route('setting.access.assignment.group-module.view', ['id' => $role->id]) }}">
                                                            <i class="fas fa-link"></i>
                                                        </a>
                                                        <a class="btn btn-info btn-sm"
                                                            href="{{ route('setting.access.role.view', ['id' => $role->id]) }}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <a class="btn btn-danger btn-sm"
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
        <div class="modal fade" id="modal-users">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
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
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
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