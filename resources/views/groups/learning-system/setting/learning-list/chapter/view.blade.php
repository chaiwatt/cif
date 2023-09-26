@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">เพิ่มหัวข้อการเรียนรู้</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.learning-system.setting.learning-list.chapter',['id' => $chapter->lesson->id ])}}">หัวข้อการเรียนรู้</a>
                        </li>
                        <li class="breadcrumb-item active">{{$chapter->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">

                        <div class="card-body">

                            <!-- Display validation errors -->
                            <form
                                action="{{route('groups.learning-system.setting.learning-list.chapter.update',['id' => $chapter->id])}}"
                                method="POST">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <input type="text" name="lessonId" value="{{$chapter->lesson->id}}" hidden>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>หัวข้อการเรียนรู้<span class="small text-danger">*</span></label>
                                            <input type="text" name="name" value="{{$chapter->name}}"
                                                class="form-control @error('name') is-invalid @enderror">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        @if ($permission->update)
                                        <button type="submit"
                                            class="btn bg-gradient-success btn-flat float-right">บันทึก</button>
                                        @endif

                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@push('scripts')


<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        searchRoute: '{{ route('setting.organization.approver.assignment.search') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>
@endpush
@endsection