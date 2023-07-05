@extends('layouts.dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/loading.css?v=1.0') }}">
@endpush
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    @include('layouts.partial.loading')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">นำเข้าไฟล์เวลา: {{$month->name}} {{$year}} ({{$workSchedule->name}})</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.time-recording-system.schedulework.time-recording')}}">ตารางทำงาน</a>
                        </li>
                        <li class="breadcrumb-item active">นำเข้าไฟล์เวลา</li>
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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12" id="table_container">
                                    <table class="table table-bordered table-striped dataTable dtr-inline">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="select_all">
                                                        <label for="select_all">เลือก</label>
                                                    </div>
                                                </th>
                                                <th>รหัสพนักงาน</th>
                                                <th>ชื่อ-สกุล</th>
                                                <th>แผนก</th>
                                                <th>การนำเข้า</th>
                                                <th>ผิดพลาด</th>
                                                <th class="text-right">เพิ่มเติม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                            <tr>
                                                <td>
                                                    <div class="icheck-primary d-inline">
                                                        <input name="users[]" type="checkbox" class="user-checkbox"
                                                            id="checkboxPrimary{{$user->id}}" value="{{$user->id}}">
                                                        <label for="checkboxPrimary{{$user->id}}"></label>
                                                    </div>

                                                </td>
                                                <td>{{$user->employee_no}}</td>
                                                <td>{{$user->prefix->name}}{{$user->name}} {{$user->lastname}}
                                                </td>
                                                <td>{{$user->company_department->name}}</td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-right">
                                                    <a class="btn btn-success btn-sm" href="">
                                                        <i class="fas fa-download">
                                                        </i>
                                                    </a>
                                                    <a class="btn btn-danger btn-sm" href="">
                                                        <i class="fas fa-eraser">
                                                        </i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $users->links() }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn bg-gradient-success btn-flat float-right"
                                        id="import_for_all">นำเข้าทุกคน</button>
                                    <input type="file" id="file-input" style="display: none;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            @endif

        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.4.1/papaparse.min.js"
    integrity="sha512-dfX5uYVXzyU8+KHqj8bjo7UkOdg18PaOtpa48djpNbZHwExddghZ+ZmzWT06R5v6NSk3ZUfsH6FNEDepLx9hPQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="module"
    src="{{ asset('assets/js/helpers/time-recording-system/schedule/assignment/import-finger-print.js?v=1') }}">
</script>
<script>
    window.params = {
        searchRoute: '{{ route('groups.time-recording-system.shift.timeattendance.search') }}',        
        batchImportRoute: '{{ route('groups.time-recording-system.schedulework.time-recording.import.batch') }}',
        singleImportRoute: '{{ route('groups.time-recording-system.schedulework.time-recording.import.single') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection