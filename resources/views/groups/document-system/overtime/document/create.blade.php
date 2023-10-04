@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">เพิ่มรายการล่วงเวลา</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.document-system.overtime.document')}}">ล่วงเวลา</a>
                        </li>
                        <li class="breadcrumb-item active">เพิ่มรายการลา</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($errors->has('userId'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-ban"></i> ผิดพลาด</h5>
                กรุณาเลือกผู้อนุมัติเอกสารอย่างน้อย 1 คน
            </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">เพิ่มรายการล่วงเวลา</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{route('groups.document-system.overtime.document.store')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <input type="text" name="manual_time" id="manual_time" value="1" hidden>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ชื่อรายการล่วงเวลา<span class="small text-danger">*</span></label>
                                            <input type="text" name="name" id="name" value="{{old('name')}}"
                                                class="form-control  @error('name') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ประเภท<span class="small text-danger">*</span></label>
                                            <select name="type" id="type" class="form-control select2"
                                                style="width: 100%;">
                                                <option value="1">วันทำงานปกติ</option>
                                                <option value="2">วันหยุด</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="form-group clearfix">

                                            <div class="icheck-primary d-inline mr-2 ">
                                                <input type="radio" id="radFixHour" name="rad" checked>
                                                <label for="radFixHour">กำหนดชั่วโมง
                                                </label>
                                            </div>
                                            <div class="icheck-primary d-inline">
                                                <input type="radio" id="radManualHour" name="rad">
                                                <label for="radManualHour">กำหนดเวลาเอง
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-12" id="content_wrapper_1"> --}}
                                        {{-- <div class="row"> --}}
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>วันที่เริ่ม (วดป. คศ)<span
                                                            class="small text-danger">*</span></label>
                                                    <input type="text" name="startDate" id="startDate"
                                                        value="{{old('startDate')}}"
                                                        class="form-control input-date-format @error('startDate') is-invalid @enderror">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ถึงวันที่ (วดป. คศ)<span
                                                            class="small text-danger">*</span></label>
                                                    <input type="text" name="endDate" id="endDate"
                                                        value="{{old('endDate')}}"
                                                        class="form-control input-date-format @error('endDate') is-invalid @enderror">
                                                </div>
                                            </div>
                                            {{--
                                        </div> --}}

                                        {{--
                                    </div> --}}
                                    <div class="col-lg-12" id="content_wrapper">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>จำนวนชั่วโมง<span class="small text-danger">*</span></label>
                                                    <input type="text" name="hour_duration" id="hour_duration" value="4"
                                                        class="form-control integer @error('hour_duration') is-invalid @enderror">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-12">
                                        <div class="card-body p-0">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>ผู้อนุมัติเอกสาร <a href="" class="btn btn-sm btn-primary"
                                                                id="get_authorized_user"><i class="fas fa-plus"></i></a>
                                                        </th>
                                                        <th style="width:100px" class="text-right">ลบ</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="sortableRows">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-12 text-right">
                                        <button class="btn bg-success mt-2">บันทึก</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-users">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="modal-user-wrapper">

                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" id="save_authorized_user">เพิ่มรายการ</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="module" src="{{asset('assets/js/helpers/document-system/overtime/document/create.js?v=1')}}">
</script>
<script src="{{ asset('assets/js/helpers/helper.js?v=1') }}"></script>
<script>
    $('.select2').select2()
    window.params = {
    
    getUsersRoute: '{{ route('groups.document-system.overtime.document.get-users') }}',
    
    url: '{{ url('/') }}',
    token: $('meta[name="csrf-token"]').attr('content')
    };

    $(document).on('click', '#radFixHour, #radManualHour', function () {
    var selection = 0;
    
    if ($('#radFixHour').is(':checked')) {
    selection = 1;
    $('#manual_time').val(1);
    // $('#content_wrapper_1').show();
    $('#content_wrapper').show();
    $('#startDate, #endDate').removeClass('input-datetime-format').addClass('input-date-format').inputmask('99/99/9999');
    } else if ($('#radManualHour').is(':checked')) {
    selection = 2;
    // $('#content_wrapper_1').show();
    $('#manual_time').val(2);
    $('#content_wrapper').hide();
    $('#startDate, #endDate').removeClass('input-date-format').addClass('input-datetime-format').inputmask('99/99/9999 99:99');
    }
    
    console.log('Selection:', selection);
    });

</script>
@endpush
@endsection