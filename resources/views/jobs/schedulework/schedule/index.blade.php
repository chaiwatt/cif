@extends('layouts.pages.dashboard')

@section('content')
@include('dashboard.partial.aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">ตารางทำงาน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">ตารางทำงาน</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($permission->create)
            <a class="btn btn-primary mb-2" href="{{route('jobs.schedulework.schedule.create')}}">
                <i class="fas fa-plus mr-1">
                </i>
                เพิ่มตารางทำงาน
            </a>
            @endif
            @if ($permission->show)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">ตารางทำงาน</h3>
                        </div>
                        <div class="card-body table-responsive p-0">

                            <table class="table table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ชื่อตารางทำงาน</th>
                                        <th>ปีตารางทำงาน</th>
                                        <th>คำอธิบาย</th>
                                        <th class="text-right">เพิ่มเติม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($workSchedules as $key=> $workSchedule)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$workSchedule->name}}</td>
                                        <td>{{$workSchedule->year}}</td>
                                        <td>{{$workSchedule->description}}</td>
                                        <td class="text-right">
                                            @if ($permission->update)
                                            <a class="btn btn-info btn-sm" href="">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                            </a>
                                            @endif
                                            @if ($permission->create)
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('jobs.schedulework.schedule.assignment', ['id' => $workSchedule->id]) }}">
                                                <i class="fas fa-link"></i>
                                                </i>
                                            </a>
                                            @endif
                                            @if ($permission->delete == true)
                                            <a class="btn btn-danger btn-sm"
                                                data-confirm='ลบตารางทำงาน "{{$workSchedule->name}}" หรือไม่?' href="#"
                                                data-id="{{$workSchedule->id}}" data-delete-route=""
                                                data-message="กะตารางทำงาน">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@push('scripts')
<script src="{{asset('assets/js/helper/helper.js?v=1')}}"></script>

@endpush
@endsection