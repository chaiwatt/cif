@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">บันทึกเวลา</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">บันทึกเวลา</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if($errors->has('error_out_payday_range'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-ban"></i> ผิดพลาด</h5>
                ไม่สามารถใช้ฟังก์ชั่นนี้นอกช่วงเวลาคำนวนเงินเดือน
            </div>
            @endif

            <div class="card card-info card-outline">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ปี</label>
                                <select name="year" id="year"
                                    class="form-control select2 @error('year') is-invalid @enderror"
                                    style="width: 100%;">
                                    @foreach ($years as $year)
                                    <option value="{{$year}}" {{ $year==date('Y') ? 'selected' : '' }}>{{$year}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>เดือน</label>
                                <select name="month" id="month"
                                    class="form-control select2 @error('month') is-invalid @enderror"
                                    style="width: 100%;">
                                    @foreach ($months as $month)
                                    <option value="{{$month->id}}" {{ $month->id == date('m') ? 'selected' : ''
                                        }}>{{$month->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12 ">
                            <button class="btn btn-primary float-right mr-2" id="search_work_schedule"><i
                                    class="fas fa-search mr-1"></i>ค้นหา</button>
                        </div>
                    </div>

                </div>
            </div>
            @if ($permission->show)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">ตารางทำงาน</h3>
                        </div>
                        <div class="card-body table-responsive p-0" id="table_container">
                            <table class="table table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ตารางทำงาน</th>
                                        <th>เดือน-ปี</th>
                                        <th class="text-right">เพิ่มเติม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($workSchedules as $key => $workSchedule)
                                    <tr>
                                        <td>{{$key +1}}</td>
                                        <td>{{$workSchedule->name}}</td>
                                        <td>{{$workSchedule->monthName($currentMonth)}} {{$year}}</td>
                                        <td class="text-right">
                                            <a class="btn btn-info btn-sm"
                                                href="{{route('groups.time-recording-system.schedulework.time-recording.import',['workScheduleId' => $workSchedule->id,'year' => $currentYear,'month' => $currentMonth])}}">
                                                <i class="fas fa-pencil-alt">
                                                </i>
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

<script type="module"
    src="{{asset('assets/js/helpers/time-recording-system/schedule/time-recording/time-recording.js?v=1')}}"></script>
<script>
    $('.select2').select2();
        window.params = {
            searchRoute: '{{ route('groups.time-recording-system.schedulework.time-recording.search') }}',
            url: '{{ url('/') }}',
            token: $('meta[name="csrf-token"]').attr('content')
        };
</script>


@endpush
@endsection