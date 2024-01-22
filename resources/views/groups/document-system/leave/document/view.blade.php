@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">รายการลา: {{$leave->user->name}}
                        {{$leave->user->lastname}}</h4>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.document-system.leave.document.view',['id' => $leave->id])}}">รายการลา</a>
                        </li>
                        <li class="breadcrumb-item active">{{$leave->user->name}}
                            {{$leave->user->lastname}}
                        </li>
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
                            <h4 class="card-title">รายการลา</h3>
                        </div>
                        <div class="card-body">
                            <input type="text" id="leaveId" value="{{$leave->id}}" hidden>
                            <div class="row">
                                <div class="col-md-6" hidden>
                                    <div class="form-group">
                                        <label>พนักงาน <span class="fw-bold text-danger">*</span></label>
                                        <select name="user" id="user"
                                            class="form-control select2 @error('user') is-invalid @enderror"
                                            style="width: 100%;">
                                            <option value="">===เลือกรายการ===</option>
                                            @foreach ($users as $user)
                                            <option value="{{ $user->id }}" @if ($user->id
                                                == $leave->user_id) selected @endif>
                                                {{ $user->employee_no}} {{$user->name}} {{$user->lastname}}
                                            </option>
                                            @endforeach

                                        </select>
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
                                            <option value="{{ $leaveType->id }}" @if ($leaveType->id
                                                == $leave->leave_type_id) selected @endif>
                                                {{ $leaveType->name }}
                                            </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>เริ่มวันที่ (วดป.) <span class="fw-bold text-danger">*</span></label>
                                        <input type="text" name="startDate" id="startDate"
                                            value="{{ date_create_from_format('Y-m-d H:i:s', $leave->from_date)->format('d/m/Y H:i') }}"
                                            class="form-control input-datetime-format @error('startDate') is-invalid @enderror">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ถึงวันที่ (วดป.)  <span class="fw-bold text-danger">*</span></label>
                                        <input type="text" name="endDate" id="endDate"
                                            value="{{ date_create_from_format('Y-m-d H:i:s', $leave->to_date)->format('d/m/Y H:i') }}"
                                            class="form-control input-datetime-format @error('endDate') is-invalid @enderror">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-info" id="btnAddFile">เพิ่มไฟล์แนบ <span
                                            id="fileName" class="text-dark"></span></button>
                                    <div class="form-group">
                                        <input type="file" accept="image/*" id="file-input" style="display: none;">
                                    </div>
                                </div>

                                <div class="col-12 text-end">
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