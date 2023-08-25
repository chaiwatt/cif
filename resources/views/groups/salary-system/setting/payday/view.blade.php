@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">เพิ่มรอบคำนวนเงินเดือน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
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
                            <h3 class="card-title">รายละเอียดรอบคำนวนเงินเดือน</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form
                                action="{{ route('groups.salary-system.setting.payday.update', ['id' => $payDay->id]) }}"
                                method="POST">
                                @method('PUT')
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ปี<span class="small text-danger">*</span></label>
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
                                            <label>ชื่อรอบคำนวนเงินเดือน<span class="small text-danger">*</span></label>
                                            <input type="text" name="name" value="{{old('name') ?? $payDay->name}}"
                                                class="form-control @error('name') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>วันที่ต้นงวด<span class="small text-danger">*</span></label>
                                            <input type="text" name="startDay"
                                                value="{{old('startDay') ?? $payDay->start_day}}"
                                                class="form-control numericInputInt @error('startDay') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>วันที่ปลายงวด<span class="small text-danger">*</span></label>
                                            <input type="text" name="endDay"
                                                value="{{old('endDay') ?? $payDay->end_day}}"
                                                class="form-control numericInputInt @error('endDay') is-invalid @enderror">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>รอบจ่าย<span class="small text-danger">*</span></label>
                                            <select name="crossMonth" id="crossMonth" class="form-control select2"
                                                style="width: 100%;">
                                                <option value="1" @if ($payDay->cross_month == 1) selected
                                                    @endif>คร่อมเดือน</option>
                                                <option value="2" @if ($payDay->cross_month == 2) selected
                                                    @endif>ในเดือน</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>เดือน<span class="small text-danger">*</span></label>
                                            <select name="paymentType" id="paymentType" class="form-control select2"
                                                style="width: 100%;">
                                                <option value="1" @if ($payDay->payment_type == 1) selected
                                                    @endif>จ่ายสิ้นเดือน</option>
                                                <option value="2" @if ($payDay->payment_type == 2) selected
                                                    @endif>จ่ายหลังวันสุดท้ายของรอบทำงาน</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="duration_wrapper" @if ($payDay->payment_type == 1)
                                        style="display:none"
                                        @endif >
                                        <div class="form-group">
                                            <label>จ่ายหลังวันสุดท้ายของรอบทำงาน<span
                                                    class="small text-danger">*</span></label>
                                            <input type="text" id="duration"
                                                value="{{old('duration') ?? $payDay->duration}}" name="duration"
                                                class="form-control numericInputInt" inputmode="text">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit"
                                            class="btn bg-gradient-success btn-flat float-right">บันทึก</button>
                                    </div>
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
</script>
@endpush
@endsection