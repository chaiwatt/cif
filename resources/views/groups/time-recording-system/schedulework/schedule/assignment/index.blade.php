@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">ตารางทำงาน: {{$workSchedule->name}} ปี{{$workSchedule->year}}</h1>
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
                                        <th>มอบหมายผู้ใช้</th>
                                        <th>เพิ่มกะทำงาน</th>
                                        <th class="text-right">เพิ่มเติม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($months as $key=> $month)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$workSchedule->name}}</td>
                                        <td>{{$month->name}} {{$workSchedule->year}}</td>
                                        <td>
                                            @php
                                            $usersAssigned = $workSchedule->isUsersAssigned($month->id,
                                            $workSchedule->year);
                                            $isExpired = $usersAssigned === 'หมดเวลา';

                                            @endphp

                                            @if ($isExpired)
                                            <span class="badge bg-gray">หมดเวลา</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                            $shiftsAdded = $workSchedule->isAllShiftsAdded($month->id,
                                            $workSchedule->year);
                                            $isExpired = $shiftsAdded === 'หมดเวลา';
                                            @endphp

                                            @if ($isExpired)
                                            <span class="badge bg-gray">หมดเวลา</span>
                                            @elseif ($shiftsAdded)
                                            <span class="badge bg-success">เพิ่มแล้ว</span>
                                            @else
                                            <span class="badge bg-danger">ยังไม่ได้เพิ่ม</span>
                                            @endif
                                        </td>
                                        <td class="text-right">

                                            @if ($permission->create || $permission->update)
                                            <a class="btn btn-success btn-sm"
                                                href="{{ route('groups.time-recording-system.schedulework.schedule.assignment.user', ['workScheduleId' => $workSchedule->id, 'year' => $workSchedule->year, 'month' => $month->id]) }}">
                                                <i class="fas fa-users"></i>
                                            </a>
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('groups.time-recording-system.schedulework.schedule.assignment.work-schedule', ['workScheduleId' => $workSchedule->id, 'year' => $workSchedule->year, 'month' => $month->id]) }}">
                                                <i class="fas fa-link"></i>
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
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>

@endpush
@endsection