@extends('layouts.dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
@endpush
<div>
    <div>
        <div class="container-fluid">
            <div class="row mb-2">
                <div>
                    <h3 class="m-0">ข่าวสมัครงาน</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.announcement-system.announcement.list')}}">ข่าวสมัครงาน</a>
                        </li>
                        <li class="breadcrumb-item active">{{$applicationNew->title}}</li>
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
                            <h4 class="card-title">รายละเอียดข่าวสมัครงาน</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <input type="text" id="applicationNewId" value="{{$applicationNew->id}}" hidden>
                            <div class="form-group">
                                <label>หัวข้อ <span class="fw-bold text-danger">*</span></label>
                                <input type="text" name="title" value="{{$applicationNew->title}}" id="title"
                                    class="form-control @error('title') is-invalid @enderror">
                            </div>
                            <div class="form-group">
                                <label>คำอธิบาย <span class="fw-bold text-danger">*</span></label>
                                <input type="text" name="description" value="{{$applicationNew->description}}"
                                    id="description" class="form-control @error('description') is-invalid @enderror">
                            </div>

                            <div class="form-group">
                                <label for="">รายละเอียด</label>
                                <textarea id="summernote" class="form-control">{{$applicationNew->body}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>สถานะ</label>
                                <select name="status" id="status" class="form-control select2" style="width: 100%;">
                                    <option value="1" @if ($applicationNew->status == 1)
                                        selected
                                        @endif>แสดง</option>
                                    <option value="2" @if ($applicationNew->status == 2)
                                        selected
                                        @endif>ไม่แสดง</option>
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
                            @if (count($applicationNewAttachments) != 0)
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-bordered table-striped dataTable dtr-inline">
                                        <thead>
                                            <tr>
                                                <th>ไฟลน์แนบ</th>
                                                <th class="text-end" style="width: 200px">เพิ่มเติม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($applicationNewAttachments as $applicationNewAttachment)
                                            <tr>
                                                <td>{{$applicationNewAttachment->name}}</td>
                                                <td class="text-end">
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{url('/storage/uploads/attachment') .'/'. $applicationNewAttachment->file}}">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <a class="btn btn-sm btn-danger delete-file"
                                                        data-id="{{$applicationNewAttachment->id}}"><i
                                                            class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="text-end">
                                <button class="btn btn-primary"
                                    id="btn-update-application-news">
                                    บันทึก</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@push('scripts')

<script type="module" src="{{asset('assets/js/helpers/job-application-system/job-application/list/update.js?v=1')}}">
</script>
<script src="{{asset('assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        storeRoute: '{{ route('groups.job-application-system.job-application.list.store') }}',
        deleteAttachmentRoute: '{{ route('groups.job-application-system.job-application.list.delete-attachment') }}',
        updateRoute: '{{ route('groups.job-application-system.job-application.list.update') }}',
        
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