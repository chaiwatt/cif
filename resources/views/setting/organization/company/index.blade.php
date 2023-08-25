@extends('layouts.setting-dashboard')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">ข้อมูลบริษัท</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">ข้อมูลบริษัท</li>
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
                            <h3 class="card-title">รายละเอียดข้อมูลบริษัท</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('setting.organization.company.update', ['id' => $company->id]) }}"
                                method="POST">
                                @method('PUT')
                                @csrf
                                <!-- Display validation errors -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>ชื่อบริษัท<span class="small text-danger">*</span></label>
                                            <input type="text" name="name" value="{{old('name') ?? $company->name}}"
                                                class="form-control @error('name') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>ที่อยู่<span class="small text-danger">*</span></label>
                                            <input type="text" name="address"
                                                value="{{old('address') ?? $company->address}}"
                                                class="form-control @error('address') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>เบอร์โทรศัพท์<span class="small text-danger">*</span></label>
                                            <input type="text" name="phone" value="{{old('phone') ?? $company->phone}}"
                                                class="form-control @error('phone') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>แฟ๊กซ์</label>
                                            <input type="text" name="fax" value="{{old('fax') ?? $company->fax}}"
                                                class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>เลขประจำตัวผู้เสียภาษี<span
                                                    class="small text-danger">*</span></label>
                                            <input type="text" name="tax" value="{{old('tax') ?? $company->tax}}"
                                                class="form-control numericInputInt @error('tax') is-invalid @enderror">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
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
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    $(function () {
        $('.select2').select2()
        //Date picker
        $('#birth_date,#start_work_date,#visa_expire_date,#work_permit_expire_date').datetimepicker({
            format: 'L'
        });
    });
</script>
@endpush
@endsection