@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">รายการลา</h1>
                </div>
                <div class="col-sm-6">
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
                        <div class="card-header">
                            <h3 class="card-title">รายการลาล่าสุด</h3>
                        </div>
                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12" id="table_container">
                                        <table class="table table-bordered table-striped dataTable dtr-inline">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>ชื่อสกุล</th>
                                                    <th>แผนก</th>
                                                    <th>ประเภทการลา</th>
                                                    <th>ช่วงวันที่</th>
                                                    <th>ครึ่งวัน</th>
                                                    <th>สถานะ</th>
                                                    <th class="text-right">เพิ่มเติม</th>
                                                </tr>
                                            </thead>
                                            <tbody id="approver_tbody">
                                                @foreach ($leaves as $key=> $leave)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$leave->user->name}} {{$leave->user->lastname}}</td>
                                                    <td>{{$leave->user->company_department->name}}</td>
                                                    <td>{{$leave->leaveType->name}}</td>
                                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d',
                                                        $leave->from_date)->format('d/m/Y') }}
                                                        - {{ \Carbon\Carbon::createFromFormat('Y-m-d',
                                                        $leave->to_date)->format('d/m/Y') }}</td>
                                                    <td>{{$leave->half_day == 1 ? 'ใช่' : '-'}}</td>
                                                    <td>@if ($leave->status === null)
                                                        <span class="badge bg-primary">รออนุมัติ</span>
                                                        @elseif ($leave->status === '1')
                                                        <span class="badge bg-success">อนุมัติแล้ว</span>
                                                        @elseif ($leave->status === '2')
                                                        <span class="badge bg-danger">ไม่อนุมัติ</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-right">
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
@push('scripts')
<script type="module" src="{{asset('assets/js/helpers/document-system/leave/document.js?v=1')}}"></script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    $('.select2').select2()
    window.params = {
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>
@endpush
@endsection