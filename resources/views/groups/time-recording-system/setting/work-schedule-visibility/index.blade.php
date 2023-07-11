@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">การมองเห็นตารางทำงาน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">ตารางทำงาน</li>
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
                            <form
                                action="{{route('groups.time-recording-system.setting.work-schedule-visibility.store')}}"
                                method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12" id="table_container">
                                        <table class="table table-bordered table-striped dataTable dtr-inline">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">เลือก</th>
                                                    <th>ชื่อตารางทำงาน</th>
                                                    <th>ปีตารางทำงาน</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($workSchedules as $workSchedule)
                                                <tr>
                                                    <td class="text-center">
                                                        <div class="icheck-primary d-inline">
                                                            <input name="workSchedules[]" type="checkbox"
                                                                id="checkboxPrimary{{$workSchedule->id}}"
                                                                value="{{$workSchedule->id}}" {{
                                                                $workSchedule->shouldUncheck() ? '' : 'checked' }}>
                                                            <label for="checkboxPrimary{{$workSchedule->id}}"></label>
                                                        </div>
                                                    </td>
                                                    <td>{{$workSchedule->name}}</td>
                                                    <td>{{$workSchedule->year}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit"
                                            class="btn bg-gradient-success btn-flat float-right">บันทึก</button>
                                        <input type="file" id="file-input" style="display: none;">
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@push('scripts')


@endpush
@endsection