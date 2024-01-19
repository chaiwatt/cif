@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">เพิ่มรอบคำนวนเงินเดือน</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.salary-system.setting.payday')}}">รอบคำนวนเงินเดือน</a>
                        </li>
                        <li class="breadcrumb-item active">เพิ่มรอบคำนวนเงินเดือน</li>
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
                            <form action="{{route('groups.salary-system.setting.payday.store')}}" method="POST">
                                @csrf

                                <div class="row gy-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ปี <span class="fw-bold text-danger">*</span></label>
                                            <select name="year" id="year"
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ชื่อรอบคำนวนเงินเดือน <span class="fw-bold text-danger">*</span></label>
                                            <input type="text" name="name" value="{{old('name')}}"
                                                class="form-control @error('name') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>งวดจ่าย <span class="fw-bold text-danger">*</span></label>
                                            <select name="paydayType" id="paydayType" class="form-control select2"
                                                style="width: 100%;">
                                                <option value="1">งวดปกติ</option>
                                                <option value="2">งวดพิเศษ (รายวัน)</option>
                                                <option value="3">งวดพิเศษ (รายเดือน)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="cantain_wrapper1">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>วันที่ต้นงวด <span class="fw-bold text-danger">*</span></label>
                                                    <input type="text" name="startDay" value="{{old('startDay')}}"
                                                        class="form-control numericInputInt @error('startDay') is-invalid @enderror">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>วันที่ปลายงวด <span class="fw-bold text-danger">*</span></label>
                                                    <input type="text" name="endDay" value="{{old('startDay')}}"
                                                        class="form-control numericInputInt @error('endDay') is-invalid @enderror">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="cantain_wrapper2" style="display:none">
                                        <div class="row" id="select_option_wrapper">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>รอบคำนวนต้น <span class="fw-bold text-danger">*</span></label>
                                                    <select name="firstPayday" id="firstPayday"
                                                        class="form-control select2" style="width: 100%;">
                                                        <option value="">==เลือกรอบคำนวนต้น==</option>
                                                        @foreach ($paydays as $payday)
                                                        <option value="{{$payday->id}}">{{$payday->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('firstPayday') <span
                                                        class="text-sm mb-0 text-danger">*กรุณาเลือกรอบคำนวนต้น</span>
                                                    @enderror

                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>รอบคำนวนปลาย <span class="fw-bold text-danger">*</span></label>
                                                    <select name="secondPayday" id="secondPayday"
                                                        class="form-control select2" style="width: 100%;">
                                                        <option value="">==เลือกรอบคำนวนปลาย==</option>
                                                        @foreach ($paydays as $payday)
                                                        <option value="{{$payday->id}}">{{$payday->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('secondPayday') <span
                                                        class="text-sm mb-0 text-danger">*กรุณาเลือกรอบคำนวนปลาย</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>รอบคำนวน <span class="fw-bold text-danger">*</span></label>
                                            <select name="crossMonth" id="crossMonth" class="form-control select2"
                                                style="width: 100%;">
                                                <option value="1">ข้ามเดือน</option>
                                                <option value="2">ในเดือน</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>เดือน <span class="fw-bold text-danger">*</span></label>
                                            <select name="paymentType" id="paymentType" class="form-control select2"
                                                style="width: 100%;">
                                                <option value="1">จ่ายสิ้นเดือน</option>
                                                <option value="2">จ่ายปลายงวด</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="duration_wrapper" style="display:none">
                                        <div class="form-group">
                                            <label>หลังปลายงวด (วัน) <span class="fw-bold text-danger">*</span></label>
                                            <input type="text" id="duration" value="7" name="duration"
                                                class="form-control numericInputInt" inputmode="text">
                                        </div>
                                    </div>
                                    @if ($permission->create)
                                    <div class="col-12 text-end mt-2">
                                        <button type="submit"
                                            class="btn btn-primary">บันทึก</button>
                                    </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="module" src="{{asset('assets/js/helpers/salary-system/setting/payday/create.js?v=1')}}"></script>
<script src="{{ asset('assets/js/helpers/helper.js?v=1') }}"></script>
<script>
    $('.select2').select2()
    $(document).on('change', '#paymentType', function (e) {
        var selectedValue = $(this).val();
        if (selectedValue === '1') {
            $('#duration_wrapper').hide();
        } else if (selectedValue === '2') {
            $('#duration_wrapper').show();
        }
    });


    window.params = {
    getPaydayRoute: '{{ route('groups.salary-system.setting.payday.get-payday') }}',
    url: '{{ url('/') }}',
    token: $('meta[name="csrf-token"]').attr('content')
    };
    
</script>

@endpush
@endsection