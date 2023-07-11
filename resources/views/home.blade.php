@extends('layouts.home')

@section('content')
<div class="container">
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5>ผิดพลาด!</h5>
        {{ session('error') }}
    </div>
    @endif
    <div class="row">
        @foreach ($groups as $group)
        <div class="col-lg-6">
            <div class="card  card-success card-outline">
                <div class="card-header">
                    <h5 class="card-title m-0"><i class="fas {{ $group->icon }} mr-2 text-gray"></i>{{ $group->name
                        }}</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $group->description }}</p>
                    <a href="{{ route('group.index', $group->id) }}" class="btn btn-primary"><i
                            class="fas fa-angle-double-right mr-2"></i>เข้าสู่ระบบงาน</a>
                </div>
            </div>
        </div>
        @endforeach
        @can('is_admin')
        <div class="col-lg-6">
            <div class="card  card-info card-outline">
                <div class="card-header">
                    <h5 class="card-title m-0"><i class="fas fa-cog mr-2 text-gray"></i>ตั้งค่าระบบ</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">ตั้งค่าระบบ</p>
                    <a href="{{route('setting')}}" class="btn btn-primary">
                        <i class="fas fa-angle-double-right mr-2"></i>เข้าสู่ระบบงาน</a>
                </div>
            </div>
        </div>
        @endcan
    </div>
</div>

{{-- @foreach ($htmlcolors as $htmlcolor)
<div class=" font-weight-normal mt-2"
    style="background-color: {{$htmlcolor->color}}; color: rgb(255, 255, 255); position: relative;height:35px"
    data-id="1">
    {{$htmlcolor->color}}
</div>
@endforeach --}}


@endsection