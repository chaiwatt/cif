@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">อนุมัติการลา</h1>
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
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">ค้นหา</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>แผนก</label>
                                <select name="companyDepartment" id="companyDepartment"
                                    class="form-control select2 @error('companyDepartment') is-invalid @enderror"
                                    style="width: 100%;">
                                    <option value="">==เลือกแผนก==</option>
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>เดือน</label>
                                <select name="month" id="month"
                                    class="form-control select2 @error('month') is-invalid @enderror"
                                    style="width: 100%;">
                                    <option value="">==เลือกเดือน==</option>
                                    @foreach ($months as $month)
                                    <option value="{{ $month->id }}" {{ old('month')==$month->id
                                        ?
                                        'selected' : '' }}>
                                        {{ $month->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>ปี</label>
                                <select name="month" id="year"
                                    class="form-control select2 @error('year') is-invalid @enderror"
                                    style="width: 100%;">
                                    @foreach ($years as $year)
                                    <option value="{{ $year }}" {{ old('year')==$year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>อื่น ๆ </label>
                                    <input type="text" name="search_string" id="search_string"
                                        value="{{old('search_string')}}" class="form-control"
                                        placeholder="รหัสพนักงาน,ชื่อ,สกุล,สายอนุมัติ">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-end">
                            <button class="btn btn-info mr-2" id="search_leave"><i
                                    class="fas fa-search mr-1"></i>ค้นหา</button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">รายการลาล่าสุด</h3>
                            {{-- <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="search_query" id="search_query"
                                        class="form-control float-right" placeholder="ค้นหา">
                                </div>
                            </div> --}}
                        </div>
                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12" id="table_container">
                                        <table class="table table-bordered table-striped dataTable dtr-inline">
                                            <thead>
                                                <tr>
                                                    <th>สายอนุมัติ</th>
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
                                            <tbody>
                                                @foreach ($leaves as $key=> $leave)
                                                @php
                                                $approver =
                                                $leave->user->approvers->where('document_type_id',1)->first()
                                                @endphp
                                                <tr>
                                                    <td>{{$approver->code}}</td>
                                                    <td>{{$leave->user->name}} {{$leave->user->lastname}}</td>
                                                    <td>{{$leave->user->company_department->name}}</td>
                                                    <td>{{$leave->leaveType->name}}</td>
                                                    <td>{{ date_create_from_format('Y-m-d H:i:s',
                                                        $leave->from_date)->format('d/m/Y H:i') }} - {{
                                                        date_create_from_format('Y-m-d H:i:s',
                                                        $leave->to_date)->format('d/m/Y H:i') }}</td>
                                                    <td>
                                                        สายอนุมัติ {{$approver->name}}
                                                        <span class="ml-3">
                                                            - {{$approver->user->name}} {{$approver->user->lastname}}
                                                            (ผู้จัดการ)
                                                            @if ($leave->manager_approve == 0)
                                                            <span class="badge bg-primary"
                                                                style="font-weight: normal;">รออนุมัติ</span>
                                                            @elseif ($leave->manager_approve == 1)
                                                            <span class="badge bg-success"
                                                                style="font-weight: normal;">อนุมัติแล้ว</span>
                                                            @elseif ($leave->manager_approve == 2)
                                                            <span class="badge bg-danger"
                                                                style="font-weight: normal;">ไม่อนุมัติ</span>
                                                            @endif
                                                            @foreach ($approver->authorizedUsers as $user)
                                                            <br>

                                                            <span class="ml-3">
                                                                - {{$user->name}} {{$user->lastname}}

                                                                @php
                                                                $approvalStatus
                                                                =$leave->getLeaderApprovalStatus($user->id);
                                                                @endphp
                                                                {{-- {{$approvalStatus}} --}}
                                                                @if ($approvalStatus === null)
                                                                <span class="badge bg-primary"
                                                                    style="font-weight: normal;">รออนุมัติ</span>
                                                                @elseif ($approvalStatus == 1)
                                                                <span class="badge bg-success"
                                                                    style="font-weight: normal;">อนุมัติแล้ว</span>
                                                                @elseif ($approvalStatus == 2)
                                                                <span class="badge bg-danger"
                                                                    style="font-weight: normal;">ไม่อนุมัติ</span>
                                                                @elseif ($approvalStatus == 0)
                                                                <span class="badge bg-primary"
                                                                    style="font-weight: normal;">รออนุมัติ</span>
                                                                @endif
                                                            </span>
                                                            @endforeach

                                                    </td>
                                                    <td>@if ($leave->status === null || $leave->status === '0')
                                                        <span class="badge bg-primary">รออนุมัติ</span>
                                                        @elseif ($leave->status === '1')
                                                        <span class="badge bg-success">อนุมัติแล้ว</span>
                                                        @elseif ($leave->status === '2')
                                                        <span class="badge bg-danger">ไม่อนุมัติ</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-right">
                                                        @if ($leave->status !== '1')
                                                        <a class="btn btn-info btn-sm approve_leave"
                                                            data-id="{{$leave->id}}"
                                                            data-name="{{$leave->user->name}} {{$leave->user->lastname}}"
                                                            data-user_id="{{$leave->user->id}}"
                                                            data-approver_id="{{$approver->id}}">
                                                            <i class="fas fa-stamp"></i>
                                                        </a>
                                                        @endif

                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            </tbody>
                                        </table>
                                        {{-- {{$leaves->links()}} --}}
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
<script type="module" src="{{asset('assets/js/helpers/document-system/leave/approval.js?v=1')}}"></script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    $('.select2').select2()
    window.params = {
        leaveApprovalRoute: '{{ route('groups.document-system.leave.approval.leave-approval') }}',
        searchRoute: '{{ route('groups.document-system.leave.approval.search') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>
@endpush
@endsection