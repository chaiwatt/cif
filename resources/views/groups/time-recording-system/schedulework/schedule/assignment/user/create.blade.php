@extends('layouts.dashboard')
@push('scripts')
<style>
    #calendar .fc-header-toolbar,
    #calendar .fc-toolbar {
        display: none;
    }
</style>
@endpush
@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">นำเข้าพนักงาน</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('groups.time-recording-system.schedulework.schedule.assignment.user', ['workScheduleId' => $workSchedule->id, 'year' => $year, 'month' => $monthId]) }}">ตารางทำงาน</a>
                        </li>
                        <li class="breadcrumb-item active">{{$workSchedule->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5> ผิดพลาด</h5>
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">รายชื่อพนักงาน</h4>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="search_query" id="search_query"
                                        class="form-control float-right" placeholder="ค้นหา">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form
                                action="{{route('groups.time-recording-system.schedulework.schedule.assignment.user.store')}}"
                                method="POST">
                                @csrf
                                <input type="text" name="month" value="{{$monthId}}" hidden>
                                <input type="text" name="year" value="{{$year}}" hidden>
                                <input type="text" name="workScheduleId" value="{{$workSchedule->id}}" hidden>
                                <div class="dataTables_wrapper dt-bootstrap4">
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
                                                        <th>ตำแหน่ง</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="employee_tbody">
                                                    @foreach ($users as $user)
                                                    <tr>
                                                        <td>
                                                            <div class="icheck-primary d-inline">
                                                                <input name="users[]" type="checkbox"
                                                                    class="user-checkbox"
                                                                    id="checkboxPrimary{{$user->id}}"
                                                                    value="{{$user->id}}">
                                                                <label for="checkboxPrimary{{$user->id}}"></label>
                                                            </div>
                                                        </td>
                                                        <td>{{$user->employee_no}}</td>
                                                        <td>{{$user->prefix->name}}{{$user->name}} {{$user->lastname}}
                                                        </td>
                                                        <td>{{$user->company_department->name}}</td>
                                                        <td>{{$user->user_position->name}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $users->links() }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        @if ($permission->create)
                                        <button type="submit"
                                            class="btn bg-gradient-success btn-flat float-right">บันทึก</button>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="module" src="{{asset('assets/js/helpers/time-recording-system/schedule/assignment/assignment.js?v=1')}}">
</script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        searchRoute: '{{ route('groups.time-recording-system.schedulework.schedule.assignment.user.search') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };

</script>
@endpush
@endsection