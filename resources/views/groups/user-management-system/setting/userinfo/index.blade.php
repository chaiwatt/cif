@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">ข้อมูลพนักงาน</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รายการพนักงาน</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($permission->show)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title m-0">รายชื่อพนักงาน</h4>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 250px;">
                                    <input type="text" name="search_query" id="search_query"
                                        class="form-control" placeholder="ค้นหา">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12 table-responsive" id="table_container">
                                        <table class="table table-borderless text-nowrap dataTable dtr-inline"
                                            id="userTable">
                                            <thead class="border-bottom">
                                                <tr>
                                                    <th>#</th>
                                                    <th>รหัสพนักงาน</th>
                                                    <th>ชื่อ-สกุล</th>
                                                    <th>แผนก</th>
                                                    <th>ประเภท</th>
                                                    <th>ตำแหน่ง</th>
                                                    <th class="text-end">เพิ่มเติม</th>
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
                                                    <td>{{$user->employee_type->name}}</td>
                                                    <td>{{$user->user_position->name}}</td>
                                                    <td class="text-end">
                                                        <a class="btn btn-action btn-edit btn-sm"
                                                            href="{{route('groups.user-management-system.setting.userinfo.view',['id' => $user->id])}}">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        {{-- <a class="btn btn-danger btn-sm"
                                                            data-confirm='ลบพนักงาน "{{$user->name}} {{$user->lastname}}" หรือไม่?'
                                                            href="#" data-id="{{$user->id}}"
                                                            data-delete-route="{{ route('setting.organization.employee.delete', ['id' => '__id__']) }}"
                                                            data-message="ผู้ใช้งาน">
                                                            <i class="fas fa-trash"></i>
                                                        </a> --}}
                                                    </td>
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
            @endif

        </div>
    </div>
</div>
@push('scripts')
<script type="module" src="{{asset('assets/js/helpers/user-management-system/setting/userinfo.js?v=1')}}">
</script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>

<script>
    window.params = {
        searchRoute: '{{ route('groups.user-management-system.setting.userinfo.search') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection