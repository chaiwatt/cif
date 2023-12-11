@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">เพิ่มรายการโบนัส</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.salary-system.salary.calculation-bonus-list')}}">รายการโบนัส</a>
                        </li>
                        <li class="breadcrumb-item active">เพิ่มรายการโบนัส</li>
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
                            <h3 class="card-title">รายละเอียด</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{route('groups.salary-system.salary.calculation-bonus-list.store')}}"
                                method="POST">
                                @csrf
                                <div class="row">
                                    <input type="text" name="manual_time" id="manual_time" value="1" hidden>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ชื่อรายการ<span class="small text-danger">*</span></label>
                                            <input type="text" name="name" value="{{old('name')}}"
                                                class="form-control  @error('name') is-invalid @enderror">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>วันที่ (วดป. คศ)<span class="small text-danger">*</span></label>
                                            <input type="text" name="issued" value="{{old('issued')}}"
                                                class="form-control input-date-format @error('issued') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-lg-12" id="content_wrapper">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>คำอธิบาย</label>
                                                    <input type="text" name="description" value="{{old('description')}}"
                                                        class="form-control @error('description') is-invalid @enderror">
                                                </div>
                                            </div>
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
</div>
@push('scripts')
<script src="{{ asset('assets/js/helpers/helper.js?v=1') }}"></script>
@endpush
@endsection