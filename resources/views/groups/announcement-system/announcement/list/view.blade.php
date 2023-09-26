@extends('layouts.dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
@endpush
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">ข่าวประกาศ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.announcement-system.announcement.list')}}">ข่าวประกาศ</a>
                        </li>
                        <li class="breadcrumb-item active">{{$announcement->title}}</li>
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
                            <h3 class="card-title">รายละเอียดข่าวประกาศ</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <input type="text" id="announcementId" value="{{$announcement->id}}" hidden>
                            <div class="form-group">
                                <label>หัวข้อ<span class="small text-danger">*</span></label>
                                <input type="text" name="title" value="{{$announcement->title}}" id="title"
                                    class="form-control @error('title') is-invalid @enderror">
                            </div>
                            <div class="form-group">
                                <label>คำอธิบาย<span class="small text-danger">*</span></label>
                                <input type="text" name="description" value="{{$announcement->description}}"
                                    id="description" class="form-control @error('description') is-invalid @enderror">
                            </div>

                            <div class="form-group">
                                <label for="">รายละเอียด</label>
                                <textarea id="summernote" class="form-control">{{$announcement->body}}</textarea>
                            </div>

                            <div class="form-group">
                                <label>สถานะ</label>
                                <select name="status" id="status" class="form-control select2" style="width: 100%;">
                                    <option value="1" @if ($announcement->status == 1)
                                        selected
                                        @endif>แสดง</option>
                                    <option value="2" @if ($announcement->status == 2)
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
                            @if (count($announcementAttachments) != 0)
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-bordered table-striped dataTable dtr-inline">
                                        <thead>
                                            <tr>
                                                <th>ไฟลน์แนบ</th>
                                                <th class="text-right" style="width: 200px">เพิ่มเติม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($announcementAttachments as $announcementAttachment)
                                            <tr>
                                                <td>{{$announcementAttachment->name}}</td>
                                                <td class="text-right">
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{url('/storage/uploads/attachment') .'/'. $announcementAttachment->file}}">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <a class="btn btn-sm btn-danger delete-file"
                                                        data-id="{{$announcementAttachment->id}}"><i
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
                            <div class="float-right">
                                <button class="btn bg-gradient-success btn-flat float-right"
                                    id="btn-update-announcement">
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

<script type="module" src="{{asset('assets/js/helpers/announcement-system/announcement/list/update.js?v=1')}}"></script>
<script src="{{asset('assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        storeRoute: '{{ route('groups.announcement-system.announcement.list.store') }}',
        deleteAttachmentRoute: '{{ route('groups.announcement-system.announcement.list.delete-attachment') }}',
        updateRoute: '{{ route('groups.announcement-system.announcement.list.update') }}',
        
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