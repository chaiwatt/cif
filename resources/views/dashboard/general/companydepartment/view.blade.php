@extends('layouts.setting.dashboard')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">แผนก: {{$companyDepartment->name}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">แผนกการทำงาน</a></li>
                        <li class="breadcrumb-item active">{{$companyDepartment->name}}</li>
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
                            <h3 class="card-title">รายละเอียดข้อมูลแผนก</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form
                                action="{{ route('setting.general.companydepartment.update', ['id' => $companyDepartment->id]) }}"
                                method="POST">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>รหัสแผนก</label>
                                            <input type="text" name="code"
                                                value="{{old('code') ?? $companyDepartment->code}}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ชื่อแผนก<span class="small text-danger">*</span></label>
                                            <input type="text" name="name"
                                                value="{{old('name') ?? $companyDepartment->name}}"
                                                class="form-control @error('name') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ชื่อแผนกภาษาอังกฤษ<span class="small text-danger">*</span></label>
                                            <input type="text" name="eng_name"
                                                value="{{old('eng_name') ?? $companyDepartment->eng_name}}"
                                                class="form-control @error('eng_name') is-invalid @enderror">
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
<script>

</script>
@endpush
@endsection