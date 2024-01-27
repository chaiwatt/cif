@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">รอบคำนวนเงินเดือน: {{$payDay->name}}</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.salary-system.setting.payday')}}">รอบคำนวนเงินเดือน</a>
                        </li>
                        <li class="breadcrumb-item active">{{$payDay->name}}</li>
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
                        <form
                            action="{{ route('groups.salary-system.setting.payday.update', ['id' => $payDay->id]) }}"
                            method="POST">
                        <div class="card-body">
                                @method('PUT')
                                @csrf

                                <div class="row gy-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ปี <span class="fw-bold text-danger">*</span></label>
                                            <select name="year"
                                                class="form-control select2 @error('year') is-invalid @enderror"
                                                style="width: 100%;">
                                                @foreach ($years as $year)
                                                <option value="{{ $year}}" @if ($year==$payDay->year) selected @endif>
                                                    {{ $year }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ชื่อรอบคำนวนเงินเดือน <span class="fw-bold text-danger">*</span></label>
                                            <input type="text" name="name" value="{{old('name') ?? $payDay->name}}"
                                                class="form-control @error('name') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>งวดจ่าย <span class="fw-bold text-danger">*</span></label>
                                            <select name="paydayType" id="paydayType" class="form-control select2"
                                                style="width: 100%;">
                                                <option value="1" @if ($payDay->type == 1) selected
                                                    @endif>งวดปกติ</option>
                                                <option value="2" @if ($payDay->type == 2) selected
                                                    @endif>งวดพิเศษ (รายวัน)</option>
                                                <option value="3" @if ($payDay->type == 3) selected
                                                    @endif>งวดพิเศษ (รายเดือน)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="cantain_wrapper1" @if ($payDay->type == 2)
                                        style="display:none"
                                        @endif>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>วันที่ต้นงวด <span class="fw-bold text-danger">*</span></label>
                                                    <input type="text" name="startDay"
                                                        value="{{old('startDay') ?? $payDay->start_day}}"
                                                        class="form-control numericInputInt @error('startDay') is-invalid @enderror">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>วันที่ปลายงวด <span class="fw-bold text-danger">*</span></label>
                                                    <input type="text" name="endDay"
                                                        value="{{old('endDay') ?? $payDay->end_day}}"
                                                        class="form-control numericInputInt @error('endDay') is-invalid @enderror">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="cantain_wrapper2" @if ($payDay->type == 1)
                                        style="display:none"
                                        @endif >
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>รอบคำนวนต้น <span class="fw-bold text-danger">*</span></label>
                                                    <select name="firstPayday" id="firstPayday"
                                                        class="form-control select2" style="width: 100%;">
                                                        <option value="">==เลือกรอบคำนวนต้น==</option>
                                                        @foreach ($paydays as $item)
                                                        <option value="{{$item->id}}" @if ($item->id ==
                                                            $payDay->first_payday_id ) selected
                                                            @endif>{{$item->name}}</option>
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
                                                        @foreach ($paydays as $item)
                                                        <option value="{{$item->id}}" @if ($item->id ==
                                                            $payDay->second_payday_id ) selected
                                                            @endif>{{$item->name}}</option>
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
                                                <option value="1" @if ($payDay->cross_month == 1) selected
                                                    @endif>ข้ามเดือน</option>
                                                <option value="2" @if ($payDay->cross_month == 2) selected
                                                    @endif>ในเดือน</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>เดือน <span class="fw-bold text-danger">*</span></label>
                                            <select name="paymentType" id="paymentType" class="form-control select2"
                                                style="width: 100%;">
                                                <option value="1" @if ($payDay->payment_type == 1) selected
                                                    @endif>จ่ายสิ้นเดือน</option>
                                                <option value="2" @if ($payDay->payment_type == 2) selected
                                                    @endif>จ่ายปลายงวด</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="duration_wrapper" @if ($payDay->payment_type == 1)
                                        style="display:none"
                                        @endif >
                                        <div class="form-group">
                                            <label>หลังปลายงวด (วัน) <span class="fw-bold text-danger">*</span></label>
                                            <input type="text" id="duration"
                                                value="{{old('duration') ?? $payDay->duration}}" name="duration"
                                                class="form-control numericInputInt" inputmode="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($permission->update)
                            <div class="card-footer card-create">
                                <button type="submit"
                                    class="btn btn-primary">บันทึก</button>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
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

    $(document).on('change', '#paydayType', function (e) {
        var selectedValue = $(this).val();
        if (selectedValue === '1') {
            $('#cantain_wrapper1').show();
            $('#cantain_wrapper2').hide();
        } else if (selectedValue === '2') {
            $('#cantain_wrapper1').hide();
            $('#cantain_wrapper2').show();
        }
    });
</script>
@endpush
@endsection