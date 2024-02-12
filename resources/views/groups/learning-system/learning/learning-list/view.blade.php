@extends('layouts.dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/loading.css?v=1.0') }}">
@endpush
<div>
    @include('layouts.partial.loading')
    <div>
        <div class="container-fluid">
            <div class="title-header">
                <div>
                    <h3 class="m-0">รายการจัดการเรียนรู้</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
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
            <div class="card">
                <div class="row">
                    <div class="col-md-3 border-end p-0">
                        <div id="accordion" style="padding: 8px 0 8px 12px;">
                            {{-- $chapter->name --}}
                            <div class="accordion" id="accordionPanelsStayOpenExample">
                            @foreach ($lesson->chapters as $key => $chapter)
                                <div class="accordion-item">
                                  <h2 class="accordion-header">
                                    <button class="accordion-button {{ $key == 0 ? "": "collapsed" }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $key }}" aria-expanded="{{ $key == 0 ? "true": "false" }}" aria-controls="collapse-{{ $key }}">
                                        <h6 class="m-0">{{$chapter->name}}</h6>
                                    </button>
                                  </h2>
                                  <div id="collapse-{{ $key }}" class="accordion-collapse collapse {{ $key == 0 ? "show": "" }}">
                                    <div>
                                        <ul class="learning-pills">
                                            @foreach ($chapter->topics as $topic)
                                            <li class="learning-item">
                                                <a href="#" class="learning-link topic-link" data-id="{{$topic->id}}">
                                                    <i class="fas fa-check-circle learning-check"></i>
                                                    {{$topic->name}}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                  </div>
                                </div>
                                @endforeach
                              </div>
                                {{-- <div id="heading{{$key}}">
                                    <h5 class="mb-0">
                                        <button class="btn" data-toggle="collapse" data-target="#collapse{{$key}}"
                                            aria-expanded="{{ $key === 0 ? 'true' : 'false' }}"
                                            aria-controls="collapse{{$key}}">
                                           
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapse{{$key}}" class="collapse {{ $key === 0 ? 'show' : '' }}"
                                    aria-labelledby="heading{{$key}}" data-parent="#accordion">
                                    <div class="card-body">
                                       
                                    </div>
                                </div> --}}
                        </div>

                    </div>
                    <div class="col-md-9 p-0">
                        <div id="content_wrapper"></div>
                    </div>
                </div>
            </div>

            @endif

        </div>
    </div>

</div>
{{-- <div class="modal-footer justify-content-between">
    {{-- <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
    <button type="button" class="btn btn-primary" id="bntUpdateReportField">ต่อไป</button>
</div>
</div>
</div>
</div>
</div> --}}
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