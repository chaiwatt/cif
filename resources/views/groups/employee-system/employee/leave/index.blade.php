@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">เพิ่มการลา</h1>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}">หน้าหลัก</a>
                        </li>
                        <li class="breadcrumb-item active">เพิ่มการลา</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4 class="card-title">รายละเอียด</h4>
                        </div>
                        <div class="card-body">
                            <input type="text" name="" id="leaveId" hidden>
                            <div class="row gy-2">
                                <div class="col-md-6">
                                    <input type="text" name="user" id="user" value="{{$user->id}}" class="form-control"
                                        hidden>
                                    <div class="form-group">
                                        <label>รหัสพนักงาน <span class="fw-bold text-danger">*</span></label>
                                        <input type="text" value="{{$user->employee_no}}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ประเภทการลา <span class="fw-bold text-danger">*</span></label>
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
                                        <label>เริ่มวันที่ (วดป.)  <span class="fw-bold text-danger">*</span></label>
                                        <input type="text" name="startDate" id="startDate" value="{{old('startDate')}}"
                                            class="form-control input-datetime-format @error('startDate') is-invalid @enderror">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ถึงวันที่ (วดป.)  <span class="fw-bold text-danger">*</span></label>
                                        <input type="text" name="endDate" id="endDate" value="{{old('endDate')}}"
                                            class="form-control input-datetime-format @error('endDate') is-invalid @enderror">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-outline-secondary" id="btnAddFile">เพิ่มไฟล์แนบ <span
                                                id="fileName" class="text-dark"></span></button>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <input type="file" accept="image/*" id="file-input" style="display: none;">

                                </div>

                                <div class="col-12 text-end">
                                    <button class="btn btn-primary" id="leave_check">ตรวจสอบ</button>
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
<script type="module" src="{{asset('assets/js/helpers/employee-system/employee/leave.js?v=1')}}"></script>
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