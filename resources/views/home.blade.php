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
        <div class="col-lg-4">
            <div class="card  card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title m-0"><i class="fas {{ $group->icon }} mr-2 text-gray"></i>{{ $group->name
                        }}</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $group->description }}</p>
                    {{-- <a href="{{ route('group.index', $group->id) }}" class="btn btn-info"><i
                            class="fas fa-angle-double-right mr-2"></i>เข้าสู่ระบบงาน</a> --}}
                    <a href="{{ route($group->default_route) }}" class="btn btn-info"><i
                            class="fas fa-angle-double-right mr-2"></i>เข้าสู่ระบบงาน</a>
                </div>
            </div>
        </div>
        @endforeach
        @can('is_admin')
        <div class="col-lg-4">
            <div class="card  card-warning card-outline">
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

@endsection