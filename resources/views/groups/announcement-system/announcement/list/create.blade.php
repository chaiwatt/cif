@extends('layouts.dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
@endpush
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">สร้างข่าวประกาศ</h1>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('groups.announcement-system.announcement.list')}}">รายการข่าวประกาศ</a>
                        </li>
                        <li class="breadcrumb-item active">สร้างข่าวประกาศ</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h4 class="card-title">รายละเอียดข่าวประกาศ</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <label>หัวข้อ <span class="fw-bold text-danger">*</span></label>
                                <input type="text" name="title" value="{{old('title')}}" id="title"
                                    class="form-control @error('title') is-invalid @enderror">
                            </div>
                            <div class="form-group">
                                <label>คำอธิบาย <span class="fw-bold text-danger">*</span></label>
                                <input type="text" name="description" value="{{old('description')}}" id="description"
                                    class="form-control @error('description') is-invalid @enderror">
                            </div>

                            <div class="form-group">
                                <label for="">รายละเอียด</label>
                                <textarea id="summernote" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>สถานะ</label>
                                <select name="status" id="status" class="form-control select2" style="width: 100%;">
                                    <option value="1">แสดง</option>
                                    <option value="2">ไม่แสดง</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="btn btn-default btn-file">
                                    <i class="fas fa-paperclip"></i> เอกสารแนบ
                                    <input type="file" name="attachment" id="attachment" multiple>
                                </div>
                                <ul id="files_wrapper">

                                </ul>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="text-end">
                                <button class="btn btn-primary" id="btn-add-announcement">บันทึก</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@push('scripts')

<script type="module" src="{{asset('assets/js/helpers/announcement-system/announcement/list/create.js?v=1')}}"></script>
<script src="{{asset('assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        storeRoute: '{{ route('groups.announcement-system.announcement.list.store') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };

        $(document).ready(function() {
        $('#summernote').summernote({
          height: 300
        });
    
      });

</script>
@endpush
@endsection