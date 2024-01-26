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
                    <h3 class="m-0">ข่าวประกาศ</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('groups.announcement-system.announcement.list')}}">ข่าวประกาศ</a>
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
                            <h4 class="card-title">รายละเอียดข่าวประกาศ</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="row card-body">
                            <div class="col-12 col-lg-3">
                                <input type="text" id="announcementId" value="{{$announcement->id}}" hidden>
                                <div class="form-group mb-2">
                                    <p class="m-0">ภาพหน้าปก <span class="fw-bold text-danger">*</span></p>
                                    <label for="announce-img-input"
                                        class="rounded-4 overflow-hidden d-flex flex-column" style="height: 308px;">
                                        {{-- style="width: 100%; height:100%; object-fit: cover;" --}}
                                        <div class="d-flex justify-content-center align-items-center"
                                            style="background: #667085; flex: 1">
                                            @if (!is_null($announcement->thumbnail))
                                                <img src="{{ route('storage.announce.thumbnail', ['image' => $announcement->thumbnail]) }}" alt="announce-preview"
                                                id="announce-preview" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('icon _Image_.png') }}" alt="announce-preview"
                                                id="announce-preview">
                                            @endif
 
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center"
                                            style="background: rgb(102, 112, 133, .5);height: 42px;">
                                            <p class="m-0 text-decoration-underline">เพิ่มรูปภาพ</p>
                                        </div>
                                    </label>
                                    <input type="file" name="announce_thumbnail" id="announce-img-input" accept="image/jpeg, image/jpg, image/png, image/gif" max="5120" hidden>
                                </div>
                                <ul class="ps-4" style="color: #F79009;">
                                    <li>ไฟล์ jpeg, jpg, png เท่านั้น</li>
                                    <li>ขนาดไฟล์ไม่เกิน 5MB เท่านั้น</li>
                                </ul>
                                <div class="form-group mb-5">
                                    <label for="attachment" class="btn btn-outline-secondary mb-3">
                                        <i class="fas fa-paperclip me-2"></i> เอกสารแนบ
                                    </label>
                                    <input type="file" name="attachment" id="attachment" multiple hidden>
                                    <ul id="files_wrapper">
                                        @foreach ($announcementAttachments as $announcementAttachment)
                                            <li class="file_content" id="attachment-{{$announcementAttachment->id}}">
                                                <a href="{{ route('storage.announce.attachment', ['file'=> $announcementAttachment->file]) }}">{{ $announcementAttachment->name }}</a>
                                                <button class="delete-file" data-id="{{$announcementAttachment->id}}"><span class="material-symbols-outlined" style="font-size: 1rem">cancel</span></button>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-12 col-lg-9">
                                <div class="form-group">
                                    <label for="title">หัวข้อ <span class="fw-bold text-danger">*</span></label>
                                    <input type="text" name="title" value="{{ $announcement->title }}" id="title"
                                        class="form-control @error('title') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="description">คำอธิบาย <span
                                            class="fw-bold text-danger">*</span></label>
                                    <input type="text" name="description" value="{{ $announcement->description }}"
                                        id="description"
                                        class="form-control @error('description') is-invalid @enderror">
                                </div>

                                <div class="form-group">
                                    <label for="summernote">รายละเอียด</label>
                                    <textarea id="summernote" class="form-control">{{ $announcement->body }}</textarea>
                                </div>
                                <div class="row gy-2 mt-2">
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="start_date">วันเริ่มประกาศ <span
                                                    class="fw-bold text-danger">*</span></label>
                                            <div class="date-box date" id="start_date" data-target-input="nearest">
                                                <input name="start_date" value="{{ $announcement->start_date }}" id="start_date_input"
                                                    type="text"
                                                    class="form-control datetimepicker-input @error('start_date') is-invalid @enderror"
                                                    data-target="#start_date">
                                                <div class="date-icon" data-target="#start_date"
                                                    data-toggle="datetimepicker">
                                                    <span class="material-symbols-outlined">
                                                        calendar_today
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="end_date">วันสิ้นสุดประกาศ</label>
                                            <div class="date-box date" id="end_date" data-target-input="nearest">
                                                <input name="end_date" value="{{ $announcement->end_date }}" type="text" id="end_date_input"
                                                    class="form-control datetimepicker-input"
                                                    data-target="#end_date">
                                                <div class="date-icon" data-target="#end_date"
                                                    data-toggle="datetimepicker">
                                                    <span class="material-symbols-outlined">
                                                        calendar_today
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="status">สถานะ</label>
                                            <select name="status" id="status" class="form-control select2" style="width: 100%;">
                                                <option value="1" @if ($announcement->status == 1)
                                                    selected
                                                    @endif>แสดง</option>
                                                <option value="2" @if ($announcement->status == 2)
                                                    selected
                                                    @endif>ไม่แสดง</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer card-create">
                            <a href="{{ route('groups.announcement-system.announcement.list') }}" class="btn btn-outline-secondary" type="button">ยกเลิก</a>
                            <button class="btn btn-primary" id="btn-update-announcement">บันทึก</button>
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
      const picture = document.getElementById('announce-img-input');
        const picturePreview = document.getElementById('announce-preview');
        picture.onchange = (event) => {
            picturePreview.src = URL.createObjectURL(event.target.files[0]);
            picturePreview.style = 'width: 100%; height: 100%; object-fit: cover;'
        }
</script>
@endpush
@endsection