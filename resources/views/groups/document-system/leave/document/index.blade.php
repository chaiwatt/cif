@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">รายการลา</h3>
                </div>
                <div  aria-label="breadcrumb">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รายการลา</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <a class="btn btn-primary mb-2" href="{{route('groups.document-system.leave.document.create')}}">
                <i class="fas fa-plus mr-1">
                </i>
                เพิ่มการลา
            </a>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">รายการลาล่าสุด</h4>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="search_query" id="search_query"
                                        class="form-control float-right" placeholder="ค้นหา">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12" id="table_container">
                                        <table class="table table-bordered table-striped dataTable dtr-inline">
                                            <thead>
                                                <tr>
                                                    <th>สายอนุมัติ</th>
                                                    <th>รหัสพนักงาน</th>
                                                    <th>ชื่อสกุล</th>
                                                    <th>แผนก</th>
                                                    <th>ประเภทการลา</th>
                                                    <th>ช่วงวันที่</th>
                                                    <th>หัวหน้างาน</th>
                                                    <th>สถานะ</th>

                                                    <th class="text-right">เพิ่มเติม</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($leaves as $key=> $leave)
                                                @php
                                                $approver =
                                                $leave->user->approvers->where('document_type_id',1)->first()
                                                @endphp
                                                <tr>
                                                    <td>{{$approver->code}}</td>
                                                    <td>{{$leave->user->employee_no}}</td>
                                                    <td>{{$leave->user->name}} {{$leave->user->lastname}}</td>
                                                    <td>{{$leave->user->company_department->name}}</td>
                                                    <td>{{$leave->leaveType->name}}</td>
                                                    <td>{{ date_create_from_format('Y-m-d H:i:s',
                                                        $leave->from_date)->format('d/m/Y H:i') }} - {{
                                                        date_create_from_format('Y-m-d H:i:s',
                                                        $leave->to_date)->format('d/m/Y H:i') }}</td>
                                                    <td>
                                                        {{$approver->name}}
                                                        <br>
                                                        <span class="ml-3">-{{$approver->user->name}}
                                                            {{$approver->user->lastname}} (ผู้จัดการ)</span>
                                                        @foreach ($approver->authorizedUsers as $user)
                                                        <br>
                                                        <span class="ml-3">-{{$user->name}}
                                                            {{$user->lastname}}</span>

                                                        @endforeach
                                                    </td>
                                                    <td>@if ($leave->status === null)
                                                        <span class="badge bg-primary">รออนุมัติ</span>
                                                        @elseif ($leave->status === '1')
                                                        <span class="badge bg-success">อนุมัติแล้ว</span>
                                                        @elseif ($leave->status === '2')
                                                        <span class="badge bg-danger">ไม่อนุมัติ</span>
                                                        @endif
                                                    </td>

                                                    <td class="text-right">

                                                        @if (!empty($leave->attachment))
                                                        <a class="btn btn-primary btn-sm show-attachment"
                                                            data-id="{{$leave->id}}">
                                                            <i class="fas fa-link"></i>
                                                        </a>
                                                        @endif
                                                        @if ($leave->status === null)
                                                        <a class="btn btn-info btn-sm"
                                                            href="{{route('groups.document-system.leave.document.view',['id' => $leave->id])}}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <a class="btn btn-danger btn-sm"
                                                            data-confirm='ลบรายการลา "{{$leave->user->name}} {{$leave->user->lastname}}" หรือไม่?'
                                                            href="#" data-id="{{$leave->id}}"
                                                            data-delete-route="{{ route('groups.document-system.leave.document.delete', ['id' => '__id__']) }}"
                                                            data-message="รายการลา">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                        @endif

                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{$leaves->links()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-attachment">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <img src="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="module" src="{{asset('assets/js/helpers/document-system/leave/document.js?v=1')}}"></script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    $('.select2').select2()
    window.params = {
        searchRoute: '{{ route('groups.document-system.leave.document.search') }}',
        getAttachmentRoute: '{{ route('groups.document-system.leave.document.get-attachment') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>
@endpush
@endsection