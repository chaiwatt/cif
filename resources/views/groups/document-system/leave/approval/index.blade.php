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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>เดือน</label>
                                <select name="month" id="month"
                                    class="form-control select2 @error('month') is-invalid @enderror"
                                    style="width: 100%;">
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
                                        placeholder="รหัสพนักงาน,ชื่อ,สกุล,ตำแหน่ง">
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
                                                        <a class="btn btn-success btn-sm approve_leave"
                                                            data-id="{{$leave->id}}"
                                                            data-name="{{$leave->user->name}} {{$leave->user->lastname}}"
                                                            data-user_id="{{$leave->user->id}}">
                                                            <i class="fas fa-stamp"></i>
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