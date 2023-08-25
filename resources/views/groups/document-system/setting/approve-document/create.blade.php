@extends('layouts.dashboard')

@section('content')

@push('styles')
<style>
    /* Change cursor to "grab" when hovering over <tr> elements */
    tr {
        cursor: grab;
    }

    /* Change cursor to "grabbing" when <tr> elements are being dragged */
    tr.ui-sortable-helper {
        cursor: grabbing;
    }
</style>
@endpush

@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">เพิ่มสายอนุมัติ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('setting.organization.approver.index')}}">สายอนุมัติ</a></li>
                        <li class="breadcrumb-item active">เพิ่มสายอนุมัติ</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">

        <div class="container-fluid">
            @if ($errors->has('userId'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-ban"></i> ผิดพลาด</h5>
                กรุณาเลือกผู้อนุมัติเอกสารอย่างน้อย 1 คน
            </div>
            @endif
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
                            <form action="{{route('groups.document-system.setting.approve-document.store')}}"
                                method="POST">
                                @csrf
                                <!-- Display validation errors -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ชื่อสายอนุมัติ<span class="small text-danger">*</span></label>
                                            <input type="text" name="name" value="{{old('name')}}"
                                                class="form-control @error('name') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>รหัสกลุ่ม (code)<span class="small text-danger">*</span></label>
                                            <input type="text" name="code" value="{{old('code')}}"
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
                                                <option value="{{ $companyDepartment->id }}" {{
                                                    in_array($companyDepartment->id, (array)
                                                    old('company_department', [])) ? 'selected' : '' }}>
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
                                                <option value="{{ $documentType->id }}" {{ in_array($documentType->id,
                                                    (array) old('document_type', [])) ?
                                                    'selected' : '' }}>
                                                    {{ $documentType->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="row">
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
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit"
                                            class="btn bg-gradient-success btn-flat float-right mt-2">บันทึก</button>
                                    </div>
                                </div>

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
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" id="save_authorized_user">เพิ่มรายการ</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="module" src="{{asset('assets/js/helpers/document-system/setting/approve-document/create.js?v=1')}}">
</script>
<script src="{{ asset('assets/js/helpers/helper.js?v=1') }}"></script>
<script>
    $(function () {
        $('.select2').select2()

        $("#sortableRows").sortable({
            // Define the placeholder appearance during dragging
            placeholder: "ui-state-highlight",
            // Update the order when the drag ends
            stop: function(event, ui) {
                // Get the new order of the rows
                var newOrder = $("#sortableRows").sortable("toArray", { attribute: "id" });

                // Reorder the rows in the table based on the new order
                $.each(newOrder, function(index, rowId) {
                $("#" + rowId).appendTo("#sortableRows");
                });
            }
            });

            // Make the cursor indicate a draggable element
            $("#sortableRows").sortable("option", "cursor", "move");
    });
    window.params = {
        
        getUsersRoute: '{{ route('groups.document-system.setting.approve-document.get-users') }}',
        
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>
@endpush
@endsection