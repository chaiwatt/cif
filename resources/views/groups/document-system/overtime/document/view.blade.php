@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">รายการล่วงเวลา</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.document-system.overtime.document')}}">รายการล่วงเวลา</a>
                        </li>
                        <li class="breadcrumb-item active">รายการล่วงเวลา</li>
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
            <input type="text" id="overtimeId" value="" hidden>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4 class="card-title">เพิ่มรายการล่วงเวลา</h4>
                        </div>
                        <div class="card-body">
                            <form
                                action="{{route('groups.document-system.overtime.document.update',['id' => $overtime->id])}}"
                                method="POST">
                                @method('PUT')
                                @csrf

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ชื่อรายการล่วงเวลา<span class="small text-danger">*</span></label>
                                            <input type="text" name="name" id="name"
                                                value="{{old('name') ?? $overtime->name}}"
                                                class="form-control  @error('name') is-invalid @enderror">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>วันที่เริ่ม (วดป. คศ)<span class="small text-danger">*</span></label>
                                            <input type="text" name="startDate" id="startDate" value="{{old('startDate') ?? \Carbon\Carbon::createFromFormat('Y-m-d',
                                                $overtime->from_date)->format('d/m/Y')}} {{$overtime->start_time}}"
                                                class="form-control input-datetime-format @error('startDate') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ถึงวันที่ (วดป. คศ)<span class="small text-danger">*</span></label>
                                            <input type="text" name="endDate" id="endDate" value="{{old('endDate') ?? \Carbon\Carbon::createFromFormat('Y-m-d',
                                                $overtime->to_date)->format('d/m/Y')}} {{$overtime->end_time}}"
                                                class="form-control input-datetime-format @error('endDate') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-12">
                                        <div>
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
                                                    @foreach ($users as $user)
                                                    <tr>
                                                        <td>{{$user->name}} {{$user->lastname}}<input type="text"
                                                                name="userId[]" value="{{$user->id}}" hidden></td>
                                                        <td class="text-right"><a href=""
                                                                class="btn btn-sm btn-danger delete-row"><i
                                                                    class="fas fa-trash"></i></a></td>
                                                    </tr>

                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button class="btn btn-success mt-2">บันทึก</button>
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
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" id="save_authorized_user">เพิ่มรายการ</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="module" src="{{asset('assets/js/helpers/document-system/overtime/document/view.js?v=1')}}"></script>
<script src="{{ asset('assets/js/helpers/helper.js?v=1') }}"></script>
<script>
    $('.select2').select2()
    window.params = {
        
        getUsersRoute: '{{ route('groups.document-system.overtime.document.get-users') }}',
        
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
        };

</script>
@endpush
@endsection