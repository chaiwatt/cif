@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">รายการรอบคำนวนเงินเดือน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รายการรอบคำนวนเงินเดือน</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($permission->create)
            <a class="btn btn-primary mb-2" href="{{route('groups.salary-system.setting.payday.create')}}">
                <i class="fas fa-plus mr-1">
                </i>
                เพิ่มรอบคำนวนเงินเดือน
            </a>
            @endif
            @if ($permission->show)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">รอบคำนวนเงินเดือน</h3>
                        </div>
                        <div class="card-body table-responsive p-0" id="table_container">
                            <table class="table table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        <th>กลุ่มพนักงาน</th>
                                        <th>รอบคำนวนเงินเดือน</th>
                                        <th>เริ่มวันที่</th>
                                        <th>ถึงวันที่</th>
                                        <th>วันที่เงินเดือนออก</th>
                                        <th class="text-right">เพิ่มเติม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payDayRanges as $payDayRange)
                                    <tr>
                                        <td>{{$payDayRange->employeeType->name}}</td>
                                        <td>{{$payDayRange->name}}</td>
                                        <td>{{$payDayRange->start}}</td>
                                        <td>{{$payDayRange->end}}</td>
                                        <td>{{$payDayRange->payday}}</td>
                                        <td class="text-right"><a class="btn btn-info btn-sm"
                                                href="{{route('groups.salary-system.setting.payday.view',['id' => $payDayRange->id])}}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm"
                                                data-confirm='ลบรอบคำนวนเงินเดือน "{{$payDayRange->name}}" หรือไม่?'
                                                href="#" data-id="{{$payDayRange->id}}"
                                                data-delete-route="{{ route('groups.salary-system.setting.payday.delete', ['id' => '__id__']) }}"
                                                data-message="รอบคำนวนเงินเดือน">
                                                <i class="fas fa-trash"></i>
                                            </a>
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