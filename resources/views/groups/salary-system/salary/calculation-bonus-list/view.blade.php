@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">รายการโบนัส</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.salary-system.salary.calculation-bonus-list')}}">รายการโบนัส</a>
                        </li>
                        <li class="breadcrumb-item active">รายการโบนัส</li>
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
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form
                                action="{{route('groups.salary-system.salary.calculation-bonus-list.update',['id' => $bonus->id])}}"
                                method="POST">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <input type="text" name="manual_time" id="manual_time" value="1" hidden>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ชื่อรายการ<span class="small text-danger">*</span></label>
                                            <input type="text" name="name" value="{{$bonus->name}}"
                                                class="form-control  @error('name') is-invalid @enderror">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>วันที่ (วดป. คศ)<span class="small text-danger">*</span></label>
                                            <input type="text" name="issued" value="{{ \Carbon\Carbon::createFromFormat('Y-m-d',
                                                        $bonus->issued)->format('d/m/Y') }}"
                                                class="form-control input-date-format @error('issued') is-invalid @enderror">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>คำอธิบาย</label>
                                            <input type="text" name="description" value="{{$bonus->description}}"
                                                class="form-control @error('description') is-invalid @enderror">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>สถานะ<span class="small text-danger">*</span></label>
                                            <select name="status" class="form-control select2 " style="width: 100%;">
                                                <option value="0" @if ($bonus->status == 0) selected @endif>ใช้งาน
                                                </option>
                                                <option value="1" @if ($bonus->status == 1) selected @endif>ปิดงวด
                                                </option>
                                            </select>
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
<script>
    $('.select2').select2()
</script>
@endpush
@endsection