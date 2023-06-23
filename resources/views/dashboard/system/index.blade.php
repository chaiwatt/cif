@extends('layouts.setting.dashboard')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">แดชบอร์ด</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">แดชบอร์ด</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-user-tie"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">พนักงานรายเดือน</span>
                            <span class="info-box-number">{{$users->where('employee_type_id',1)->count()}}</span>
                        </div>

                    </div>

                </div>

                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-user"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">พนักงานรายงัน</span>
                            <span class="info-box-number">{{$users->where('employee_type_id',2)->count()}}</span>
                        </div>
                    </div>

                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="fas fa-layer-group"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">จำนวนแผนก</span>
                            <span class="info-box-number">{{$companyDepartments->total()}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">แสดงจำนวนพนักงานในแผนก</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-7">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>แผนก</th>
                                                <th class="text-center">จำนวนพนักงาน</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($companyDepartments as $index => $companyDepartment)
                                            <tr>
                                                <td>{{ $index + 1 + ($companyDepartments->perPage() *
                                                    ($companyDepartments->currentPage() - 1))}}</td>
                                                <td>{{ $companyDepartment->name }}</td>
                                                <td class="text-center">{{$companyDepartment->UsersCount}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>

                                    </table>

                                </div>
                                <div class="col-lg-5">
                                    <canvas id="employee_donutChart"
                                        style="min-height: 370px; height: 370px; max-height: 370px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            {{$companyDepartments->links()}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">แสดงบทบาทและการมอบหมาย</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-7">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>บทบาท</th>
                                                <th>กลุ่มทำงาน</th>
                                                <th class="text-center">จำนวนมอบหมาย</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    <ul>
                                                        @foreach ($role->role_group_jsons as $item)
                                                        <li style="padding: 5px;">{{$item->group->name}}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td class="text-center">{{ $role->users->count() }}</td>
                                            </tr>

                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-5">
                                    <canvas id="role_donutChart"
                                        style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    var employeeDonutChartCanvas = $('#employee_donutChart').get(0).getContext('2d');
        var employeeDonutData = {
            labels: @json($employeeDonutData['labels']),
            datasets: [{
                data: @json($employeeDonutData['datasets'][0]['data']),
                backgroundColor: @json($employeeDonutData['datasets'][0]['backgroundColor']),
            }]
        };
        var employeeDonutOptions = {
            maintainAspectRatio: false,
            responsive: true,
        };
    
        new Chart(employeeDonutChartCanvas, {
            type: 'doughnut',
            data: employeeDonutData,
            options: employeeDonutOptions
        });
    
        var roleDonutChartCanvas = $('#role_donutChart').get(0).getContext('2d');
        var roleDonutData = {
            labels: @json($roleDonutData['labels']),
            datasets: [{
                data: @json($roleDonutData['datasets'][0]['data']),
                backgroundColor: @json($roleDonutData['datasets'][0]['backgroundColor']),
            }]
        };
        var roleDonutOptions = {
            maintainAspectRatio: false,
            responsive: true,
        };
    
        new Chart(roleDonutChartCanvas, {
            type: 'doughnut',
            data: roleDonutData,
            options: roleDonutOptions
        });
</script>

@endpush
@endsection