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
                            <form action="{{route('groups.salary-system.setting.payday.store')}}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ชื่อรอบคำนวนเงินเดือน<span class="small text-danger">*</span></label>
                                            <input type="text" name="name" value="{{old('name')}}"
                                                class="form-control @error('name') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ประเภทพนักงาน<span class="small text-danger">*</span></label>
                                            <select name="employeeType"
                                                class="form-control select2 @error('employeeType') is-invalid @enderror"
                                                style="width: 100%;">
                                                @foreach ($employeeTypes as $employeeType)
                                                <option value="{{ $employeeType->id }}" {{
                                                    old('employeeType')==$employeeType->id
                                                    ?
                                                    'selected' : '' }}>
                                                    {{ $employeeType->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>วันที่เริ่ม<span class="small text-danger">*</span></label>
                                            <input type="text" name="start" value="{{old('start')}}"
                                                class="form-control numericInputMonth @error('start') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ถึงวันที่<span class="small text-danger">*</span></label>
                                            <input type="text" name="end" value="{{old('end')}}"
                                                class="form-control numericInputMonth @error('end') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>วันเงินเดือนออก<span class="small text-danger">*</span></label>
                                            <input type="text" name="payday" value="{{old('payday')}}"
                                                class="form-control numericInputMonth @error('payday') is-invalid @enderror">
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
</script>
@endpush
@endsection