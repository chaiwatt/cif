@extends('layouts.pages.dashboard')

@section('content')
@include('dashboard.partial.aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">ตารางทำงาน: {{$workSchedule->name}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route($viewRoute)}}">ตารางทำงาน</a></li>
                        <li class="breadcrumb-item active">{{$workSchedule->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
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
                                        <th>ตารางทำงาน</th>
                                        <th>เดือน</th>
                                        <th>ปี</th>
                                        <th>การมอบหมาย</th>
                                        <th class="text-right">เพิ่มเติม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($months as $key=> $month)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$workSchedule->name}}</td>
                                        <td>{{$month->name}}</td>
                                        <td>{{$workSchedule->year}}</td>
                                        <td><span class="badge bg-danger">ยังไม่ได้มอบหมาย ถ้าเป็นเดือนก่อนหน้า
                                                แต่ไม่ได้มอบหมายใช้คำว่า หมดเวลามอบหมาย</span></td>
                                        <td class="text-right">

                                            @if ($permission->update)
                                            <a class="btn btn-success btn-sm">
                                                <i class="fas fa-users"></i>
                                            </a>
                                            <a class="btn btn-primary btn-sm" href="">
                                                <i class="fas fa-link"></i>
                                                </i>
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