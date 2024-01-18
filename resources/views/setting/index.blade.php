@extends('layouts.setting-dashboard')

@section('content')

<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h2 class="m-0">แดชบอร์ด</h2>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">แดชบอร์ด</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row px-2">
                <div class="col-lg-4 col-sm-6 col-12 px-2 mb-3">
                    <div class="d-flex gap-4 p-4 bg-white rounded-4">
                        <span class="material-symbols-outlined text-white rounded-circle d-flex justify-content-center align-items-center" style="background: #3538CD; font-size: 36px; width: 64px; height: 64px;">
                            group
                        </span>
                        <div class="d-flex flex-column justify-content-between">
                            <span>พนักงานรายเดือน</span>
                            <h2 class="m-0">{{$users->where('employee_type_id',1)->count()}}</h2>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12 px-2 mb-3">
                    <div class="d-flex gap-4 p-4 bg-white rounded-4">
                        <span class="material-symbols-outlined text-white rounded-circle d-flex justify-content-center align-items-center" style="background: #47CA88; font-size: 36px; width: 64px; height: 64px;">
                            person
                        </span>
                        <div class="d-flex flex-column justify-content-between">
                            <span>พนักงานรายวัน</span>
                            <h2 class="m-0">{{$users->where('employee_type_id',2)->count()}}</h2>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12 px-2 mb-3">
                    <div class="d-flex gap-4 p-4 bg-white rounded-4">
                        <span class="material-symbols-outlined text-white rounded-circle d-flex justify-content-center align-items-center" style="background: #9B8AFB; font-size: 36px; width: 64px; height: 64px;">
                            stacks
                        </span>
                        <div class="d-flex flex-column justify-content-between">
                            <span>จำนวนแผนก</span>
                            <h2 class="m-0">{{$companyDepartments->total()}}</h2>
                        </div>

                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12 px-3 mb-3">
                    <div class="card border-0 rounded-4">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-6 py-3 ps-3 p-0">
                                    <div class="pt-3 pb-5 px-3">
                                        <h3 class="m-0">แผนกทำงาน</h3>
                                    </div>
                                    <canvas id="employee_donutChart"
                                        style="min-height: 370px; height: 370px; max-height: 370px; max-width: 100%;"></canvas>
                                </div>
                                <div class="col-lg-6 dashboard-chart-table px-4">
                                    <table class="table table-borderless border-bottom">
                                        <thead class="border-bottom">
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
                                    {{$companyDepartments->links('pagination::bootstrap-4')}}
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 px-3">
                    <div class="card border-0 rounded-4">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-6 py-3 ps-3 p-0">
                                    <div class="pt-3 pb-5 px-3">
                                        <h3 class="m-0">บทบาทและการมอบหมาย</h3>
                                    </div>
                                    <canvas id="role_donutChart"
                                        style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                                </div>
                                <div class="col-lg-6 dashboard-chart-table px-4">
                                    <table class="table table-borderless border-bottom">
                                        <thead class="border-bottom">
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
            legend: {
                show: true,
                position: 'bottom',
                align:'start'
            },

        };
    
        new Chart(employeeDonutChartCanvas, {
            type: 'doughnut',
            data: employeeDonutData,
            options: employeeDonutOptions,
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
            legend: {
                show: true,
                position: 'bottom',
                align:'start',
            },
            
        };
    
        new Chart(roleDonutChartCanvas, {
            type: 'doughnut',
            data: roleDonutData,
            options: roleDonutOptions,
        });
</script>

@endpush
@endsection