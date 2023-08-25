@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">เพิ่มรายการลา</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.salary-system.setting.payday')}}">รายการลา</a>
                        </li>
                        <li class="breadcrumb-item active">เพิ่มรายการลา</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <input type="text" id="leaveId" value="" hidden>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">เพิ่มรายการลา</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>พนักงาน<span class="small text-danger">*</span></label>
                                        <select name="user" id="user"
                                            class="form-control select2 @error('user') is-invalid @enderror"
                                            style="width: 100%;">
                                            <option value="">===เลือกรายการ===</option>
                                            @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user')==$user->id
                                                ?
                                                'selected' : '' }}>
                                                {{ $user->employee_no}} {{$user->name}} {{$user->lastname}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ประเภทการลา<span class="small text-danger">*</span></label>
                                        <select name="leaveType" id="leaveType"
                                            class="form-control select2 @error('leaveType') is-invalid @enderror"
                                            style="width: 100%;">
                                            <option value="">===เลือกรายการ===</option>
                                            @foreach ($leaveTypes as $leaveType)
                                            <option value="{{ $leaveType->id }}" {{ old('leaveType')==$leaveType->id
                                                ?
                                                'selected' : '' }}>
                                                {{ $leaveType->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>เริ่มวันที่ (วดป.) <span class="small text-danger">*</span></label>
                                        <input type="text" name="startDate" id="startDate" value="{{old('startDate')}}"
                                            class="form-control input-datetime-format @error('startDate') is-invalid @enderror">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ถึงวันที่ (วดป.) <span class="small text-danger">*</span></label>
                                        <input type="text" name="endDate" id="endDate" value="{{old('endDate')}}"
                                            class="form-control input-datetime-format @error('endDate') is-invalid @enderror">
                                    </div>
                                </div>
                                <button type="button" class="btn btn-info" id="btnAddFile">เพิ่มไฟล์แนบ <span
                                        id="fileName" class="text-dark"></span></button>

                                <div class="form-group">
                                    <input type="file" accept="image/*" id="file-input" style="display: none;">

                                </div>

                                <div class="col-12 text-right">
                                    <button class="btn bg-primary" id="leave_check">ตรวจสอบ</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-leave-info">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row mb-2" id="modal_container">



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="module" src="{{asset('assets/js/helpers/document-system/leave/document.js?v=1')}}"></script>
<script src="{{ asset('assets/js/helpers/helper.js?v=1') }}"></script>

<script>
    $('.select2').select2()
    window.params = {
        checkLeaveRoute: '{{ route('groups.document-system.leave.document.check-leave') }}',
        storeRoute: '{{ route('groups.document-system.leave.document.store') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>
@endpush
@endsection