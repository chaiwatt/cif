@extends('layouts.setting-dashboard')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0">สายอนุมัติ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('setting.organization.approver.index')}}">สายอนุมัติ</a></li>
                        <li class="breadcrumb-item active">{{$approver->name}}</li>
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
                            <h3 class="card-title">รายละเอียดข้อมูลสายอนุมัติ</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('setting.organization.approver.update', ['id' => $approver->id]) }}"
                                method="POST">
                                @method('PUT')
                                @csrf
                                <!-- Display validation errors -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>สายอนุมัติ<span class="small text-danger">*</span></label>
                                            <input type="text" name="name" value="{{old('name') ?? $approver->name}}"
                                                class="form-control @error('name') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>แผนก<span class="small text-danger">*</span></label>
                                            <select name="company_department"
                                                class="form-control select2 @error('company_department') is-invalid @enderror"
                                                style="width: 100%;">
                                                @foreach ($companyDepartments as $companyDepartment)
                                                <option value="{{ $companyDepartment->id }}" @if ($companyDepartment->id
                                                    == $approver->company_department_id) selected @endif>
                                                    {{ $companyDepartment->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ประเภทเอกสาร<span class="small text-danger">*</span></label>
                                            <select name="document_type"
                                                class="form-control select2 @error('document_type') is-invalid @enderror"
                                                style="width: 100%;">
                                                @foreach ($documentTypes as $documentType)
                                                <option value="{{ $documentType->id }}" @if ($documentType->id
                                                    == $approver->document_type_id) selected @endif>
                                                    {{ $documentType->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ผู้อนุมัติลำดับที่1<span class="small text-danger">*</span></label>
                                            <select name="approver_one"
                                                class="form-control select2 @error('approver_one') is-invalid @enderror"
                                                style="width: 100%;">
                                                @foreach ($approvers as $item)
                                                <option value="{{ $item->id }}" @if ($item->id
                                                    == $approver->approver_one_id) selected @endif>
                                                    {{ $item->name }} {{ $item->lastname }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ผู้อนุมัติลำดับที่2</label>
                                            <select name="approver_two"
                                                class="form-control select2 @error('approver_two') is-invalid @enderror"
                                                style="width: 100%;">
                                                <option value="">==เลือกผู้อนุมัติลำดับที่2==</option>
                                                @foreach ($approvers as $item)
                                                <option value="{{ $item->id }}" @if ($item->id
                                                    == $approver->approver_two_id) selected @endif>
                                                    {{ $item->name }} {{ $item->lastname }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
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
<script src="{{ asset('assets/js/helpers/helper.js?v=1') }}"></script>
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