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
                    <h3 class="m-0">เพิ่มรายละเอียดการเรียนรู้</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.learning-system.setting.learning-list.chapter.topic',['id' => $topic->chapter->id ])}}">หัวข้อการเรียนรู้</a>
                        </li>
                        <li class="breadcrumb-item active">{{$topic->name}}</li>
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
                            <h4 class="card-title">รายละเอียดการเรียนรู้</h4>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <input type="text" id="chapterId" value="{{$topic->chapter->id}}" hidden>
                            <input type="text" id="topicId" value="{{$topic->id}}" hidden>
                            <div class="form-group">
                                <label>หัวข้ <<span class="fw-bold text-danger">*</span></label>
                                <input type="text" name="name" value="{{$topic->name}}" id="name"
                                    class="form-control @error('name') is-invalid @enderror">
                            </div>

                            <div class="form-group">
                                <label for="">รายละเอียด</label>
                                <textarea id="summernote" class="form-control">{{$topic->body}}</textarea>
                            </div>
                            <div class="form-group">
                                <div class="btn btn-default btn-file">
                                    <i class="fas fa-paperclip"></i> เอกสารแนบ
                                    <input type="file" name="attachment" id="attachment" multiple>
                                </div>
                                <ul id="files_wrapper">

                                </ul>
                            </div>
                            @if (count($topicAttachments) != 0)
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
                                            @foreach ($topicAttachments as $topicAttachment)
                                            <tr>
                                                <td>{{$topicAttachment->name}}</td>
                                                <td class="text-end">
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{url('/storage/uploads/attachment') .'/'. $topicAttachment->file}}">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <a class="btn btn-sm btn-danger delete-file"
                                                        data-id="{{$topicAttachment->id}}"><i
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
                        <div class="card-footer card-create">
                                <button class="btn btn-primary" id="btn-update-topic">
                                    บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@push('scripts')

<script type="module"
    src="{{asset('assets/js/helpers/learning-system/setting/learning-list/chapter/topic/update.js?v=1')}}"></script>
<script src="{{asset('assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        updateRoute: '{{ route('groups.learning-system.setting.learning-list.chapter.topic.update') }}',
        deleteAttachmentRoute: '{{ route('groups.learning-system.setting.learning-list.chapter.topic.delete-attachment') }}',
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