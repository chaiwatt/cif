@extends('layouts.dashboard')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
    @endpush

    <div>
        <div>
            @if ($errors->any())
                <div class="alert alert-danger m-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center my-4 px-4">
                    <div>
                        <h3 class="m-0">สร้างข่าวประกาศ</h1>
                            {{-- {{ route('groups.announcement-system.announcement.list.store') }} --}}
                    </div>
                    <div aria-label="breadcrumb">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('groups.announcement-system.announcement.list') }}">รายการข่าวประกาศ</a>
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
                            <form action="{{ route('groups.announcement-system.announcement.list.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-header">
                                    <h4 class="card-title">รายละเอียดข่าวประกาศ</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="row card-body">
                                    <div class="col-12 col-lg-3">
                                        <div class="form-group mb-2">
                                            <p class="m-0">ภาพหน้าปก <span class="fw-bold text-danger">*</span></p>
                                            <label for="announce-img-input"
                                                class="rounded-4 overflow-hidden d-flex flex-column" style="height: 308px;">
                                                {{-- style="width: 100%; height:100%; object-fit: cover;" --}}
                                                <div class="d-flex justify-content-center align-items-center"
                                                    style="background: #667085; flex: 1">
                                                    <img src="{{ asset('icon _Image_.png') }}" alt="announce-preview"
                                                        id="announce-preview">
                                                </div>
                                                <div class="d-flex align-items-center justify-content-center"
                                                    style="background: rgb(102, 112, 133, .5);height: 42px;">
                                                    <p class="m-0 text-decoration-underline">เพิ่มรูปภาพ</p>
                                                </div>
                                            </label>
                                            <input type="file" name="announce_thumbnail" id="announce-img-input" hidden>
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
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-9">
                                        <div class="form-group">
                                            <label for="title">หัวข้อ <span class="fw-bold text-danger">*</span></label>
                                            <input type="text" name="title" value="{{ old('title') }}" id="title"
                                                class="form-control @error('title') is-invalid @enderror">
                                        </div>
                                        <div class="form-group">
                                            <label for="description">คำอธิบาย <span
                                                    class="fw-bold text-danger">*</span></label>
                                            <input type="text" name="description" value="{{ old('description') }}"
                                                id="description"
                                                class="form-control @error('description') is-invalid @enderror">
                                        </div>

                                        <div class="form-group">
                                            <label for="summernote">รายละเอียด</label>
                                            <textarea id="summernote" class="form-control"></textarea>
                                        </div>
                                        <div class="row gy-2 mt-2">
                                            <div class="col-12 col-lg-6">
                                                <div class="form-group">
                                                    <label for="start_date">วันเริ่มประกาศ <span
                                                            class="fw-bold text-danger">*</span></label>
                                                    <div class="date-box date" id="start_date" data-target-input="nearest">
                                                        <input name="start_date" value="{{ old('start_date') }}"
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
                                                        <input name="end_date" value="{{ old('end_date') }}" type="text"
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
                                                    <select name="status" id="status" class="form-select select2"
                                                        style="width: 100%;">
                                                        <option value="1">แสดง</option>
                                                        <option value="2">ไม่แสดง</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- /.card-body -->
                                <div class="pb-4">
                                    <div class="text-end">
                                        <button class="btn btn-primary" id="btn-add-announcement">บันทึก</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @push('scripts')
        <script type="module" src="{{ asset('assets/js/helpers/announcement-system/announcement/list/create.js?v=1') }}">
        </script>
        <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('assets/js/helpers/helper.js?v=1') }}"></script>
        <script>
            /*window.params = {
                storeRoute: '{{ route('groups.announcement-system.announcement.list.store') }}',
                url: '{{ url('/') }}',
                token: $('meta[name="csrf-token"]').attr('content')
            };*/

            $(document).ready(function() {
                $('#summernote').summernote({
                    height: 300
                });

            });
            $(function() {
                $('.select2').select2()
                $('#start_date,#end_date').datetimepicker({
                    format: 'L'
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
