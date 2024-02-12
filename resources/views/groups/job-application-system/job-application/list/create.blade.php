@extends('layouts.dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
@endpush
<div>
    <div>
        <div class="container-fluid">
            @if ($errors->any())
                <div class="alert alert-danger m-4">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <ul>
                        @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="title-header">
                <div>
                    <h3 class="m-0">เพิ่มข่าวสมัครงาน</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('groups.announcement-system.announcement.list')}}">ข่าวสมัครงาน</a>
                        </li>
                        <li class="breadcrumb-item active">เพิ่มข่าวสมัครงาน</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('groups.job-application-system.job-application.list.store') }}" method="POST" class="card card-primary card-outline">
                        @csrf
                        <div class="card-header">
                            <h4 class="card-title">รายละเอียดข่าวสมัครงาน</h4>
                        </div>
                        <!-- /.card-header -->
                        {{-- เปลี่ยน API เป็น Form --}}
                        <div class="card-body">
                            <div class="row gy-2">
                                <div class="col-12 form-group">
                                    <label for="title">ตำแหน่งงาน <span class="fw-bold text-danger">*</span></label>
                                    <input type="text" name="title" value="{{old('title')}}" id="title"
                                        class="form-control @error('title') is-invalid @enderror">
                                </div>
    
                                <div class="col-12 form-group">
                                    <label for="summernote">รายละเอียด</label>
                                    <textarea id="summernote" name="summernote" class="form-control"></textarea>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="col-12 form-group">
                                        <label for="amount_apply">จำนวนที่เปิดรับ <span class="fw-bold text-danger">*</span></label>
                                        <input type="number" name="amount_apply" value="{{old('amount_apply')}}" id="amount_apply"
                                            class="form-control @error('amount_apply') is-invalid @enderror">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="col-12 form-group">
                                        <label for="start_date">วันเริ่มรับสมัคร <span class="fw-bold text-danger">*</span></label>
                                        <div class="date-box date" id="start_date" data-target-input="nearest">
                                            <input name="start_date" value="{{ old('start_date') }}" type="text"
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
                                <div class="col-12 col-lg-4">
                                    <div class="col-12 form-group">
                                        <label for="end_date">วันสิ้นสุดรับสมัคร</label>
                                        <div class="date-box date" id="end_date" data-target-input="nearest">
                                            <input name="end_date" value="{{ old('end_date') }}" type="text"
                                                class="form-control datetimepicker-input @error('end_date') is-invalid @enderror"
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
                                <div class="col-12 col-lg-8">
                                    <div class="col-12 form-group">
                                        <label for="application_form">URL แบบฟอร์มสมัครงาน (Google form) <span class="fw-bold text-danger">*</span></label>
                                        <input type="text" name="application_form" value="{{old('application_form')}}" id="application_form"
                                            class="form-control @error('application_form') is-invalid @enderror">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="status">สถานะ <span class="fw-bold text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control select2" style="width: 100%;">
                                        <option value="1">แสดง</option>
                                        <option value="2">ไม่แสดง</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer card-create">
                            <a href="{{ route('groups.job-application-system.job-application.list') }}" class="btn btn-outline-secondary" type="button">ยกเลิก</a>
                            <button class="btn btn-primary" type="submit">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@push('scripts')

{{-- <script type="module" src="{{asset('assets/js/helpers/job-application-system/job-application/list/create.js?v=1')}}"> --}}
</script>
<script src="{{asset('assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    // window.params = {
    //     storeRoute: '{{ route('groups.job-application-system.job-application.list.store') }}',
    //     url: '{{ url('/') }}',
    //     token: $('meta[name="csrf-token"]').attr('content')
    // };
        $(document).ready(function() {
            $('.select2').select2()
            $('#start_date,#end_date').datetimepicker({
                    format: 'L'
                });
            $('#summernote').summernote({
            height: 300
            });
      });

</script>
@endpush
@endsection