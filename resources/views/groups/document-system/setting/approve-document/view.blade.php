@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="title-header">
                <div>
                    <h3 class="m-0">สายอนุมัติ</h4>
                </div>
                <div aria-label="breadcrumb"> 
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.document-system.setting.approve-document')}}">สายอนุมัติ</a>
                        </li>
                        <li class="breadcrumb-item active">{{$approver->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($errors->has('userId'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <h5><i class="icon fas fa-ban"></i> ผิดพลาด</h5>
                กรุณาเลือกผู้อนุมัติเอกสารอย่างน้อย 1 คน
            </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4 class="card-title">รายละเอียดข้อมูลสายอนุมัติ</h4>
                        </div>
                        <form
                            action="{{ route('groups.document-system.setting.approve-document.update', ['id' => $approver->id]) }}"
                            method="POST">
                            <div class="card-body">
                                @method('PUT')
                                @csrf
                                <!-- Display validation errors -->
                                <div class="row gy-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ชื่อสายอนุมัติ<span class="small text-danger">*</span></label>
                                            <input type="text" name="name" value="{{old('name') ?? $approver->name}}"
                                                class="form-control @error('name') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>รหัสกลุ่ม (code)<span class="small text-danger">*</span></label>
                                            <input type="text" name="code" value="{{old('code') ?? $approver->code}}"
                                                class="form-control @error('code') is-invalid @enderror">
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ผู้จัดการ<span class="small text-danger">*</span></label>
                                            <select name="manager"
                                                class="form-control select2 @error('manager') is-invalid @enderror"
                                                style="width: 100%;">
                                                @foreach ($users as $user)
                                                <option value="{{ $user->id }}" @if ($approver->user_id == $user->id)
                                                    selected
                                                    @endif>
                                                    {{ $user->name }} {{ $user->lastname }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>หัวหน้างาน<span class="small text-danger">*</span></label>
                                            <select name="leader[]"
                                                class="form-control select2 @error('leader') is-invalid @enderror"
                                                style="width: 100%;" multiple>
                                                @foreach ($users as $user)
                                                {{-- {{$user->approveAuthorities}} --}}
                                                @php
                                                $isApprover = $user->isApprover($approver->id,$user->id);
                                                @endphp
                                                <option value="{{ $user->id }}" @if ($isApprover!=null) selected @endif>
                                                    {{ $user->name }} {{ $user->lastname }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer card-create">
                                <button type="submit"
                                    class="btn btn-primary">บันทึก</button>
                            </div>

                        {{-- <div class="row">
                            <div class="col-12">
                                <div class="card-body p-0">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>ผู้อนุมัติเอกสาร <a href="" class="btn btn-sm btn-primary"
                                                        id="get_authorized_user"><i class="fas fa-plus"></i></a>
                                                </th>
                                                <th style="width:100px" class="text-right">ลบ</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sortableRows">
                                            @foreach ($approver->authorizedUsers as $name)
                                            <tr>
                                                <td>{{$name->name}} {{$name->lastname}}<input type="text"
                                                        name="userId[]" value="{{$name->id}}" hidden></td>
                                                <td class="text-right"><a href=""
                                                        class="btn btn-sm btn-danger delete-row"><i
                                                            class="fas fa-trash"></i></a></td>
                                            </tr>

                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> --}}
                        {{-- <div class="row">

                        </div> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-users">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="modal-user-wrapper">

                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-close" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" id="save_authorized_user">เพิ่มรายการ</button>
            </div>
        </div>
    </div>
</div>
</div>
@push('scripts')
<script type="module" src="{{asset('assets/js/helpers/document-system/setting/approve-document/view.js?v=1')}}">
</script>
<script src="{{ asset('assets/js/helpers/helper.js?v=1') }}"></script>
<script>
    $(function () {
        $('.select2').select2()
    });
    window.params = {
            getUsersRoute: '{{ route('groups.document-system.setting.approve-document.get-users') }}',
            
            url: '{{ url('/') }}',
            token: $('meta[name="csrf-token"]').attr('content')
            };
</script>
@endpush
@endsection