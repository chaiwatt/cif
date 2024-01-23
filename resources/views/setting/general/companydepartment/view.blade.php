@extends('layouts.setting-dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">แผนก: {{$companyDepartment->name}}</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
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
                            <h4 class="card-title">รายละเอียดข้อมูลแผนก</h4>
                        </div>
                        <div class="card-body">
                            <form
                                action="{{ route('setting.general.companydepartment.update', ['id' => $companyDepartment->id]) }}"
                                method="POST">
                                @method('PUT')
                                @csrf
                                <div class="row gy-2">
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
                                            <label>ชื่อแผนก <span class="fw-bold text-danger">*</span></label>
                                            <input type="text" name="name"
                                                value="{{old('name') ?? $companyDepartment->name}}"
                                                class="form-control @error('name') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ชื่อแผนกภาษาอังกฤษ <span class="fw-bold text-danger">*</span></label>
                                            <input type="text" name="eng_name"
                                                value="{{old('eng_name') ?? $companyDepartment->eng_name}}"
                                                class="form-control @error('eng_name') is-invalid @enderror">
                                        </div>
                                    </div>
                                </div>
                                    <div class="mt-2 text-end">
                                        <button type="submit"
                                            class="btn btn-primary">บันทึก</button>
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