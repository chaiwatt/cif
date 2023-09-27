@extends('layouts.dashboard')
@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">รอบคำนวนเงินเดือน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รอบคำนวนเงินเดือน</li>
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
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <select name="year" id="year"
                                        class="form-control @error('year') is-invalid @enderror" style="width: 100%;">
                                        @foreach ($years as $year)
                                        <option value="{{$year}}" {{ $year==date('Y') ? 'selected' : '' }}>{{$year}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0" id="table_container">
                            <table class="table table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        <th>กลุ่มพนักงาน</th>
                                        <th>จำนวนพนักงาน</th>
                                        <th>ปี</th>
                                        <th class="text-right">เพิ่มเติม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paydays as $payday)
                                    <tr>
                                        <td>{{$payday->name}}</td>
                                        <td>{{$payday->users->count()}}</td>
                                        <td>{{$payday->year}}</td>
                                        <td class="text-right">
                                            <a class="btn btn-success btn-sm"
                                                href="{{ route('groups.salary-system.setting.payday.assignment-user', ['id' => $payday->id]) }}">
                                                <i class="fas fa-users"></i>
                                            </a>
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('groups.salary-system.setting.payday.assignment', ['id' => $payday->id]) }}">
                                                <i class="fas fa-link"></i>
                                            </a>
                                            @if ($permission->update)
                                            <a class="btn btn-info btn-sm"
                                                href="{{route('groups.salary-system.setting.payday.view',['id' => $payday->id])}}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            @endif

                                            @if ($permission->delete)
                                            <a class="btn btn-danger btn-sm"
                                                data-confirm='ลบรอบคำนวนเงินเดือน "{{$payday->name}}" หรือไม่?' href="#"
                                                data-id="{{$payday->id}}"
                                                data-delete-route="{{ route('groups.salary-system.setting.payday.delete', ['id' => '__id__']) }}"
                                                data-message="รอบคำนวนเงินเดือน">
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
<script type="module" src="{{asset('assets/js/helpers/salary-system/setting/payday/index.js?v=1')}}"></script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        searchRoute: '{{ route('groups.salary-system.setting.payday.search') }}',        
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>
@endpush
@endsection