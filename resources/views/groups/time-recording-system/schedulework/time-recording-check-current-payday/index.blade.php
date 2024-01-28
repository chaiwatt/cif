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
                    <h3 class="m-0">ตรวจสอบเวลารอบเงินเดือนปัจจุบัน</h3>
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
                            @if (count($users) !=0)
                            <div class="card-tools d-flex align-items-center" id="filter-container">
                                <div class="form-group mr-2 mb-0">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="search_query" id="search_query"
                                            class="form-control" placeholder="ค้นหา">
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-info btn-sm active">
                                            <input type="radio" name="options" id="option_0" autocomplete="off"
                                                checked="">
                                            ทั้งหมด
                                        </label>
                                        <label class="btn btn-info btn-sm">
                                            <input type="radio" name="options" id="option_1" autocomplete="off">
                                            สำเร็จ
                                        </label>
                                        <label class="btn btn-info btn-sm">
                                            <input type="radio" name="options" id="option_2" autocomplete="off"> ผิดพลาด
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @endif

                        </div>
                        <div>
                            <div class="row">
                                <div class="col-sm-12" id="table_container">
                                    <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                        <thead class="border-bottom">
                                            <tr>
                                                <th class="text-center" style="width: 150px">ตรวจสอบ</th>
                                                <th>รอบเงินเดือน</th>
                                                <th style="width: 200px">วันที่ผิดพลาด</th>
                                                <th style="width: 200px">รหัสพนักงาน</th>
                                                <th>ชื่อ-สกุล</th>
                                                <th>แผนก</th>
                                                <th class="text-end" style="width: 120px">แก้ไข</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                            <tr>
                                                <td class="text-center">

                                                    @if (count($user->getErrorDate()) > 0)
                                                    <i class="fas fa-times-circle text-danger"></i>
                                                    @else
                                                    <i class="fas fa-check-circle text-success"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    <ul>
                                                        @foreach ($user->getPaydayWithTodays() as $getPaydayWithToday)
                                                        <li>{{$getPaydayWithToday->name}}</li>
                                                        @endforeach
                                                    </ul>


                                                    {{-- {{$user->getPaydayWithToday()->name}} --}}
                                                </td>
                                                <td>
                                                    @if (count($user->getErrorDate()) > 0)
                                                    <ul>
                                                        @foreach ($user->getErrorDate() as $dateIn)
                                                        <li>{{ \Carbon\Carbon::parse($dateIn)->format('d/m/Y') }}</li>
                                                        @endforeach
                                                    </ul>
                                                    @endif
                                                </td>
                                                <td>{{ $user->employee_no }}</td>
                                                <td>{{ $user->prefix->name }}{{
                                                    $user->name }} {{
                                                    $user->lastname }}</td>
                                                <td>{{ $user->company_department->name
                                                    }}</td>
                                                <td class="text-end">
                                                    @php
                                                    $paydayDetailWithToday = $user->getPaydayDetailWithToday();
                                                    @endphp
                                                    
                                                    <a class="btn btn-sm btn-action btn-edit" data-id="{{$user->id}}"
                                                        data-startDate="{{$paydayDetailWithToday->start_date}}"
                                                        data-endDate="{{$paydayDetailWithToday->end_date}}" id="user"><i
                                                            class="fas fa-pencil-alt"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{$users->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            @endif

        </div>
    </div>

    <div class="modal fade" id="modal-user-time-record">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12" id="table_modal_container">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-attachment">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12 mb-2">
                            <img src="" class="img-fluid">
                        </div>
                        <div class="col-12">
                            <input type="text" id="workScheduleAssignmentUserFileId" hidden>
                            <input type="text" id="workScheduleAssignmentUserId" hidden>
                            <div class="form-group float-right">
                                <button type="button" class="btn btn-danger d-none" id="delete-image">ลบ</button>
                                <button type="button" class="btn btn-primary" id="btnAddFile">เพิ่มไฟล์รูป</button>
                                <div class="form-group">
                                    <input type="file" accept="image/*" id="file-input" style="display: none;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-leave-attachment">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <img src="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="modal-footer justify-content-between">
    {{-- <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button> 
    <button type="button" class="btn btn-primary" id="bntUpdateReportField">ต่อไป</button>
</div>
</div>
</div>
</div>
</div> --}}
@push('scripts')

<script type="module"
    src="{{ asset('assets/js/helpers/time-recording-system/schedulework/time-recording-check-current-payday/index.js?v=1') }}">
</script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        searchRoute: '{{ route('groups.time-recording-system.schedulework.time-recording-check-current-payday.search') }}',        
        viewUserRoute: '{{ route('groups.time-recording-system.schedulework.time-recording-check-current-payday.view-user') }}',
        updateRoute: '{{ route('groups.time-recording-system.schedulework.time-recording-check-current-payday.update') }}',
        getImageRoute: '{{ route('groups.time-recording-system.schedulework.time-recording-check-current-payday.get-image') }}',
        uploadImageRoute: '{{ route('groups.time-recording-system.schedulework.time-recording-check-current-payday.upload-image') }}',
        deleteImageRoute: '{{ route('groups.time-recording-system.schedulework.time-recording-check-current-payday.delete-image') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection