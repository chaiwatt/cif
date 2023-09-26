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
                    <h1 class="m-0">เพิ่มรายละเอียดการเรียนรู้</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
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
                            <h3 class="card-title">รายละเอียดการเรียนรู้</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <input type="text" id="chapterId" value="{{$topic->chapter->id}}" hidden>
                            <input type="text" id="topicId" value="{{$topic->id}}" hidden>
                            <div class="form-group">
                                <label>หัวข้อ<span class="small text-danger">*</span></label>
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
                                                <th class="text-right" style="width: 200px">เพิ่มเติม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($topicAttachments as $topicAttachment)
                                            <tr>
                                                <td>{{$topicAttachment->name}}</td>
                                                <td class="text-right">
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
                        <div class="card-footer">
                            <div class="float-right">
                                <button class="btn bg-gradient-success btn-flat float-right" id="btn-update-topic">
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