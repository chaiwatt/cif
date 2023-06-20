@extends('layouts.pages.home')

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
                    <h5 class="card-title m-0">{{ $group->name }}</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $group->description }}</p>
                    <a href="{{ route('group.index', $group->id) }}" class="btn btn-primary">>>
                        เข้าสู่ระบบงาน</a>
                </div>
            </div>
        </div>
        @endforeach
        @can('is_admin')
        <div class="col-lg-6">
            <div class="card  card-success card-outline">
                <div class="card-header">
                    <h5 class="card-title m-0">ตั้งค่าระบบ</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">ตั้งค่าระบบ</p>
                    <a href="{{route('setting')}}" class="btn btn-primary">>>
                        เข้าสู่ระบบงาน</a>
                </div>
            </div>
        </div>
        @endcan

    </div>
</div>
@endsection