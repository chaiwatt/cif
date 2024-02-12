@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="title-header">
                <div>
                    <h3 class="m-0">เพิ่มรายการโบนัส</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
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
                            <h4 class="card-title">รายละเอียด</h4>
                        </div>
                        <form action="{{route('groups.salary-system.salary.calculation-bonus-list.store')}}"
                            method="POST">
                        <div class="card-body">
                                @csrf
                                <div class="row gy-2">
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

                                </div>
                            </div>
                            <div class="cif-modal-footer">
                                <button class="btn btn-primary">บันทึก</button>
                            </div>
                        </form>
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