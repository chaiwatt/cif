@extends('layouts.pages.dashboard')

@section('content')
@include('dashboard.partial.aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">กะการทำงาน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">กะการทำงาน</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($permission->create)
            <a class="btn btn-primary mb-2" href="{{route('jobs.shift.timeattendance.create')}}">
                <i class="fas fa-plus mr-1">
                </i>
                เพิ่มกะการทำงาน
            </a>
            @endif
            @if ($permission->show)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">กะการทำงาน</h3>
                        </div>
                        <div class="card-body table-responsive p-0">

                            <table class="table table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        {{-- <th>รหัสกะการทำงาน</th> --}}
                                        <th>ชื่อกะการทำงาน</th>
                                        <th>เวลาเริ่มงาน</th>
                                        <th>เวลาเลิกงาน</th>
                                        <th class="text-right">เพิ่มเติม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($shifts->where('base_shift',1) as $shift)
                                    <tr>
                                        {{-- <td>{{$shift->code}}</td> --}}
                                        <td>{{$shift->name}}</td>
                                        <td>{{$shift->start}}</td>
                                        <td>{{$shift->end}}</td>
                                        <td class="text-right">
                                            @if ($permission->update)
                                            <a class="btn btn-info btn-sm"
                                                href="{{ route('jobs.shift.timeattendance.view', ['id' => $shift->id]) }}">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                            </a>
                                            @endif
                                            @if ($permission->create)
                                            <a class="btn btn-success btn-sm"
                                                href="{{ route('jobs.shift.timeattendance.duplicate', ['id' => $shift->id]) }}">
                                                <i class="fas fa-copy"></i>
                                                </i>
                                            </a>
                                            @endif

                                            @if ($permission->delete == true)
                                            <a class="btn btn-danger btn-sm"
                                                data-confirm='ลบกะการทำงาน "{{$shift->name}}" หรือไม่?' href="#"
                                                data-id="{{$shift->id}}"
                                                data-delete-route="{{ route('jobs.shift.timeattendance.delete', ['id' => '__id__']) }}"
                                                data-message="กะการทำงาน">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            @endif
                                        </td>
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