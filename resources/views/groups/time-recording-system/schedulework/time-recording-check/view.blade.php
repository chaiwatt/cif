@extends('layouts.dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/loading.css?v=1.0') }}">
@endpush
<div>
    @include('layouts.partial.loading')
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">{{$month->name}} {{$year}} ({{$workSchedule->name}})
                    </h3>
                    <input type="text" id="schedule_type_id" value="{{$workSchedule->schedule_type_id}}" hidden>
                    <input type="text" id="work_schedule_id" value="{{$workSchedule->id}}" hidden>
                    <input type="text" id="month_id" value="{{$month->id}}" hidden>
                    <input type="text" id="year" value="{{$year}}" hidden>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.time-recording-system.schedulework.time-recording')}}">ตารางทำงาน</a>
                        </li>
                        <li class="breadcrumb-item active">{{$month->name}} {{$year}} ({{$workSchedule->name}})</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <a class="btn btn-primary mb-3" id="show_modal">
                        ตรวจสอบการบันทึกเวลา
                    </a>
                    @if ($permission->create)
                    <button class="btn bg-success float-right" id="add_note"><i class="fas fa-comments mr-2"></i>
                        เพิ่มโน้ต</button>
                    @endif
                </div>
            </div>
            @if ($permission->show)

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">พนักงาน</h4>
                            <div class="card-tools" id="filter-container" style="display: none;">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-info btn-sm active">
                                        <input type="radio" name="options" id="option_0" autocomplete="off" checked="">
                                        ทั้งหมด
                                    </label>
                                    <label class="btn btn-info btn-sm">
                                        <input type="radio" name="options" id="option_1" autocomplete="off">
                                        สำเร็จ
                                    </label>
                                    <label class="btn btn-info btn-sm">
                                        <input type="radio" name="options" id="option_2" autocomplete="off"> ผิดพลาด
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12" id="table_container">
                                    <table class="table table-bordered table-striped dataTable dtr-inline">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 150px">ตรวจสอบ</th>
                                                <th style="width: 200px">วันที่ผิดพลาด</th>
                                                <th style="width: 200px">รหัสพนักงาน</th>
                                                <th>ชื่อ-สกุล</th>
                                                <th>แผนก</th>
                                                <th class="text-right" style="width: 120px">แก้ไข</th>
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


            </div>


            @endif

        </div>
    </div>

    <div class="modal fade" id="modal-date-range">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="startDate">เริ่มวันที่ (วดป. คศ)<span
                                        class="small text-danger">*</span></label>
                                <input type="text" class="form-control input-date-format" id="startDate">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="endDate">ถึงวันที่ (วดป. คศ)<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control input-date-format" id="endDate">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group float-right">
                                <button type="button" class="btn btn-primary" id="check-time-record">ตกลง</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-user-time-record">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12" id="table_modal_container">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-add-note">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="startDate">โน้ต</label><br>
                                <textarea type="text" class="form-control" id="note" rows="3"></textarea>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="auto_text" id="checkbox-auto-text">
                                <label for="auto_text">
                                    ข้อความอัตโนมัติ
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group float-right">
                                <button type="button" class="btn btn-primary" id="save_note">บันทึก</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-attachment" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12 mb-2">
                            <img src="" class="img-fluid">
                        </div>
                        <div class="col-12">
                            <input type="text" id="workScheduleAssignmentUserFileId" hidden>
                            <input type="text" id="workScheduleAssignmentUserId" hidden>
                            <div class="form-group float-right">
                                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                                <button type="button" class="btn btn-danger d-none" id="delete-image">ลบ</button>
                                <button type="button" class="btn btn-primary" id="btnAddFile">เพิ่มไฟล์รูป</button>
                                <div class="form-group">
                                    <input type="file" accept="image/*" id="file-input" style="display: none;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-leave-attachment">
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

</div>
</div>
</div>
</div>
@push('scripts')
<script type="module"
    src="{{ asset('assets/js/helpers/time-recording-system/schedule/time-recording/time-recording-check.js?v=1') }}">
</script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        timeRecordCheckRoute: '{{ route('groups.time-recording-system.schedulework.time-recording-check.time-record-check') }}',        
        viewUserRoute: '{{ route('groups.time-recording-system.schedulework.time-recording-check.view-user') }}',
        updateHourRoute: '{{ route('groups.time-recording-system.schedulework.time-recording-check.update-hour') }}',
        updateRoute: '{{ route('groups.time-recording-system.schedulework.time-recording-check.update') }}',
        saveNoteRoute: '{{ route('groups.time-recording-system.schedulework.time-recording-check.save-note') }}',
        getImageRoute: '{{ route('groups.time-recording-system.schedulework.time-recording-check.get-image') }}',
        uploadImageRoute: '{{ route('groups.time-recording-system.schedulework.time-recording-check.upload-image') }}',
        deleteImageRoute: '{{ route('groups.time-recording-system.schedulework.time-recording-check.delete-image') }}',
        getLeaveAttachmentRoute: '{{route('groups.time-recording-system.schedulework.time-recording-check.get-leave-attachment') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection