@extends('layouts.dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/loading.css?v=1.0') }}">
@endpush
<div>
    @include('layouts.partial.loading')
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">นำเข้าไฟล์เวลารอบเงินเดือนปัจจุบัน</h3>
                    <ul class="mt-2">
                        @foreach ($paydayDetails as $paydayDetail)
                        <li>
                            <h4>{{$paydayDetail->payday->name}} (รอบเงินเดือน {{date('d/m/Y',
                                strtotime($paydayDetail->start_date))}}
                                -
                                {{date('d/m/Y', strtotime($paydayDetail->end_date))}})</h4>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
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
                            <h4 class="card-title">พนักงาน</h4>
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
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn bg-gradient-success btn-flat float-right"
                                        id="show_file_open">นำเข้า</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            @endif

        </div>
    </div>
    <div class="modal fade" id="modal-date-range">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <input type="file" id="file-inputs" style="display: none;" multiple>
                            </div>

                            <button type="button" class="btn btn-success"
                                id="import_file_inputs">เลือกไฟล์และนำเข้า</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    {{-- <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button> --}}
    <button type="button" class="btn btn-primary" id="bntUpdateReportField">ต่อไป</button>
</div>
</div>
</div>
</div>
</div>
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.4.1/papaparse.min.js"
    integrity="sha512-dfX5uYVXzyU8+KHqj8bjo7UkOdg18PaOtpa48djpNbZHwExddghZ+ZmzWT06R5v6NSk3ZUfsH6FNEDepLx9hPQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="module"
    src="{{ asset('assets/js/helpers/time-recording-system/schedulework/time-recording-check-current-payday/view.js?v=1') }}">
</script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {       
        batchImportRoute: '{{ route('groups.time-recording-system.schedulework.time-recording.import.batch-auto-detect') }}',
        singleImportRoute: '{{ route('groups.time-recording-system.schedulework.time-recording.import.single') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection