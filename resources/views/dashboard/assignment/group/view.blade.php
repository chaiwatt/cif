@extends('layouts.setting.dashboard')
@push('styles')

@endpush
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" id="role_id" data-id="{{$role->id}}">บทบาท: {{$role->name}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">{{$role->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <a class="btn btn-primary mb-2" id="un_assignment_group_button" href="">
                <i class="fas fa-plus mr-1">
                </i>
                เพิ่มกลุ่มทำงาน
            </a>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">รายชื่อกลุ่มทำงาน</h3>
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
                                                    <th>ชื่อกลุ่มทำงาน</th>
                                                    <th class="text-right">เพิ่มเติม</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($groups as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{$item->group->name}}</td>
                                                    <td class="text-right">
                                                        <a class="btn btn-primary btn-sm"
                                                            id="un_assignment_module_button"
                                                            data-id="{{$item->group->id}}" data-role="{{$role->id}}">
                                                            <i class="fas fa-link"></i>
                                                        </a>
                                                        <a class="btn btn-danger btn-sm"
                                                            data-confirm='ลบกลุ่มทำงาน "{{$item->group->name}}" หรือไม่?'
                                                            href="#" data-id="{{$item->group->id}}"
                                                            data-role="{{$role->id}}"
                                                            data-delete-route="{{ route('setting.assignment.group.delete', ['roleId' => '__roleId__', 'groupId' =>'__groupId__'])}}"
                                                            data-message="กลุ่มทำงาน">
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
    <div class="modal fade" id="modal-group">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">เลือกกลุ่มทำงาน</h3>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table id="group_modal_table" class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th style="width: 200px;">เลือก</th>
                                                <th>กลุ่มทำงาน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" id="bntSaveGroup">บันทึก</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="modal-module" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">ตั้งค่าบทบาท</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="location.reload()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                {{-- <div class="card-header">
                                    <h3 class="card-title">ตั้งค่าโมดูล</h3>
                                </div> --}}
                                <div class="card-body table-responsive p-0">
                                    <table id="module_modal_table" class="table">
                                        <thead>
                                            <tr>
                                                <th>โมดูล</th>
                                                <th>การใช้งาน</th>
                                                <th>งาน</th>
                                                <th>แสดง</th>
                                                <th>สร้าง</th>
                                                <th>แก้ไข</th>
                                                <th>ลบ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"
                        onclick="location.reload()">ปิด</button>
                    <button type="button" class="btn btn-primary" id="bntSaveModule">บันทึก</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
@push('scripts')

<script type="module" src="{{asset('assets/js/helper/dashboard/assignment/group.js?v=1')}}"></script>
<script type="module" src="{{asset('assets/js/helper/dashboard/assignment/module.js?v=1')}}"></script>
<script>
    window.params = {
        getGroupRoute: '{{ route('api.get-group') }}',
        moduleJsonRoute: "{{ route('api.get-module-json') }}",
        storeGroupRoute: '{{ route('setting.assignment.group.store') }}',
        updateModuleJsonRoute: "{{ route('setting.module.update-module-json') }}",
        
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection