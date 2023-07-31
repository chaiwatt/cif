@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">รายการลา: {{$leave->user->name}}
                        {{$leave->user->lastname}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
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
                            <h3 class="card-title">รายการลา</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <input type="text" id="leaveId" value="{{$leave->id}}" hidden>
                            <div class="row">
                                <div class="col-md-6" hidden>
                                    <div class="form-group">
                                        <label>พนักงาน<span class="small text-danger">*</span></label>
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
                                        <label>ประเภทการลา<span class="small text-danger">*</span></label>
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
                                        <label>วันที่เริ่ม (วดป. คศ)<span class="small text-danger">*</span></label>
                                        <input type="text" name="startDate" id="startDate" value="{{old('startDate') ?? \Carbon\Carbon::createFromFormat('Y-m-d',
                                            $leave->from_date)->format('d/m/Y')}}"
                                            class="form-control input-date-format @error('startDate') is-invalid @enderror">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ถึงวันที่ (วดป. คศ)<span class="small text-danger">*</span></label>
                                        <input type="text" name="endDate" id="endDate" value="{{old('endDate') ?? \Carbon\Carbon::createFromFormat('Y-m-d',
                                            $leave->to_date)->format('d/m/Y')}}"
                                            class="form-control input-date-format @error('endDate') is-invalid @enderror">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ลาครึ่งวัน</label>
                                        <select name="haftDayLeave" id="haftDayLeave"
                                            class="form-control select2 @error('haftDayLeave') is-invalid @enderror"
                                            style="width: 100%;">
                                            <option value="">===เลือกรายการ===</option>
                                            <option value="1" {{ $leave->half_day == 1 ? 'selected' : '' }}>ใช่</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ครึ่งวัน</label>
                                        <select name="haftDayLeaveType" id="haftDayLeaveType"
                                            class="form-control select2 @error('haftDayLeaveType') is-invalid @enderror"
                                            style="width: 100%;">
                                            <option value="">===เลือกรายการ===</option>
                                            <option value="1" {{ $leave->half_day_type == 1 ? 'selected' : ''
                                                }}>ครึ่งวันแรก</option>
                                            <option value="2" {{ $leave->half_day_type == 2 ? 'selected' : ''
                                                }}>ครึ่งวันหลัง (ใช้ไม่ได้กรณีลาหลายวัน)</option>
                                        </select>
                                    </div>
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
                    <div class="row mb-2">
                        <div class="col-12" id="modal_container">

                        </div>

                        <div class="col-md-12">
                            <button class="btn bg-success float-right" id="save_leave">บันทึก</button>
                        </div>


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