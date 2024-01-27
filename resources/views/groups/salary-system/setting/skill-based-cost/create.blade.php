@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">เพิ่มค่าทักษะ</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.salary-system.setting.skill-based-cost')}}">ค่าทักษะ</a>
                        </li>
                        <li class="breadcrumb-item active">เพิ่มค่าทักษะ</li>
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
                        <form action="{{route('groups.salary-system.setting.skill-based-cost.store')}}"
                            method="POST">
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ชื่อทักษะ <span class="fw-bold text-danger">*</span></label>
                                            <input type="text" name="name" value="{{old('name')}}"
                                                class="form-control @error('name') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>มูลค่า <span class="fw-bold text-danger">*</span></label>
                                            <input type="text" name="cost" value="{{old('cost')}}"
                                                class="form-control numericInputInt @error('cost') is-invalid @enderror">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($permission->create)
                            <div class="card-footer card-create">
                                <button type="submit"class="btn btn-primary">บันทึก</button>
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
@endpush
@endsection