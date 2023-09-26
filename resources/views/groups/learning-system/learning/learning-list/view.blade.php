@extends('layouts.dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/loading.css?v=1.0') }}">
@endpush
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    @include('layouts.partial.loading')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">รายการจัดการเรียนรู้
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a>
                        </li>
                        <li class="breadcrumb-item active">จัดการเรียนรู้</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">

            @if ($permission->show)
            <div class="row">
                <div class="col-md-3">
                    <div id="accordion">
                        @foreach ($lesson->chapters as $key => $chapter)
                        <div class="card card-info card-outline">
                            <div class="card-header" id="heading{{$key}}">
                                <h5 class="mb-0">
                                    <button class="btn" data-toggle="collapse" data-target="#collapse{{$key}}"
                                        aria-expanded="{{ $key === 0 ? 'true' : 'false' }}"
                                        aria-controls="collapse{{$key}}">
                                        {{$chapter->name}}
                                    </button>
                                </h5>
                            </div>

                            <div id="collapse{{$key}}" class="collapse {{ $key === 0 ? 'show' : '' }}"
                                aria-labelledby="heading{{$key}}" data-parent="#accordion">
                                <div class="card-body">
                                    <ul class="nav nav-pills flex-column">
                                        @foreach ($chapter->topics as $topic)
                                        <li class="nav-item">
                                            <a href="" class="nav-link topic-link" data-id="{{$topic->id}}"><i
                                                    class="fas fa-dot-circle mr-2"></i>
                                                {{$topic->name}}</a>
                                        </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
                <div class="col-md-9">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">{{$lesson->name}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row" id="content_wrapper">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endif

        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    {{-- <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button> --}}
    <button type="button" class="btn btn-primary" id="bntUpdateReportField">ต่อไป</button>
</div>
</div>
</div>
</div>
</div>
@push('scripts')
<script type="module" src="{{asset('assets/js/helpers/learning-system/learning/learning-list/view.js?v=1')}}"></script>

<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        contentRoute: '{{ route('groups.learning-system.learning.learning-list.content') }}',        
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection