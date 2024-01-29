@extends('layouts.setting-dashboard')
@push('styles')

@endpush
@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0" id="role_id" data-id="{{$role->id}}">บทบาท: {{$role->name}}</h3>
                </div>
                <div aria-label="breadcrumb"> 
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('setting.access.role.index')}}">บทบาท</a>
                        </li>
                        <li class="breadcrumb-item active">{{$role->name}}</li>
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
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">รายชื่อกลุ่มทำงาน</h4>
                           <div class="d-flex gap-3">
                                <a class="btn btn-header" id="un_assignment_group_button">
                                    <i class="fas fa-plus">
                                    </i>
                                    เพิ่มกลุ่มทำงาน
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
                                    <div class="col-sm-12 table-responsive">
                                        <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                            <thead class="border-bottom">
                                                <tr>
                                                    <th>#</th>
                                                    <th>ชื่อกลุ่มทำงาน</th>
                                                    <th class="text-end">เพิ่มเติม</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($groups as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{$item->group->name}}</td>
                                                    <td class="text-end">
                                                        <a class="btn btn-action btn-links btn-sm"
                                                            id="un_assignment_module_button"
                                                            data-id="{{$item->group->id}}" data-role="{{$role->id}}">
                                                            <i class="fas fa-link"></i>
                                                        </a>
                                                        <a class="btn btn-action btn-delete btn-sm"
                                                            data-confirm='ลบกลุ่มทำงาน "{{$item->group->name}}" หรือไม่?'
                                                            href="#" data-id="{{$item->group->id}}"
                                                            data-role="{{$role->id}}"
                                                            data-delete-route="{{ route('setting.access.assignment.group-module.delete', ['roleId' => '__roleId__', 'groupId' =>'__groupId__'])}}"
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
                <div class="cif-modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div>
                                    <h3 class="card-title">เลือกกลุ่มทำงาน</h3>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table id="group_modal_table" class="table table-borderless text-nowrap">
                                        <thead class="border-bottom">
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
                <div class="cif-modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="cif-modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body table-responsive p-0">
                                    <table id="module_modal_table" class="table table-borderless text-nowrap">
                                        <thead class="border-bottom">
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
                <div class="cif-modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        onclick="location.reload()">ยกเลิก</button>
                    <button type="button" class="btn btn-primary" id="bntSaveModule">บันทึก</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
@push('scripts')

<script type="module" src="{{asset('assets/js/helpers/setting/access/assignment/group/group.js?v=1')}}"></script>
<script type="module" src="{{asset('assets/js/helpers/setting/access/assignment/module/module.js?v=1')}}"></script>

<script>
    window.params = {
        getGroupRoute: '{{ route('api.get-group') }}',
        moduleJsonRoute: "{{ route('api.get-module-json') }}",
        storeGroupRoute: "{{ route('setting.access.assignment.group-module.store') }}",
        updateModuleJsonRoute: "{{ route('setting.access.assignment.group-module.update-module-json') }}",
        
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection