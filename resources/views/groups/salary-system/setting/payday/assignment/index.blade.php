@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">รอบคำนวนเงินเดือน:{{$payday->name}} ปี {{$payday->year}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.salary-system.setting.payday')}}">รอบคำนวนเงินเดือน</a></li>
                        <li class="breadcrumb-item active">{{$payday->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($permission->create)
            <a class="btn btn-primary mb-2" id="add_payday">
                <i class="fas fa-plus mr-1"></i>
                เพิ่มวันที่
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
                                        <th>เดือน</th>
                                        <th>เริ่มวันที่</th>
                                        <th>ถึงวันที่</th>
                                        <th>วันที่จ่ายเงินเดือน</th>
                                        <th class="text-right">เพิ่มเติม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paydayDetials as $paydayDetail)
                                    <tr>
                                        <td>{{$paydayDetail->month->name}} {{$payday->year}}</td>
                                        <td>{{\Carbon\Carbon::createFromFormat('Y-m-d',$paydayDetail->start_date)->format('d/m/Y')}}
                                        </td>
                                        <td>{{\Carbon\Carbon::createFromFormat('Y-m-d',$paydayDetail->end_date)->format('d/m/Y')}}
                                        </td>
                                        <td>{{\Carbon\Carbon::createFromFormat('Y-m-d',$paydayDetail->payment_date)->format('d/m/Y')}}
                                        </td>
                                        @if ($permission->update)
                                        <td class="text-right">
                                            <a class="btn btn-info btn-sm update-payday" href="#"
                                                data-id="{{$paydayDetail->id}}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </td>
                                        @endif
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
    <div class="modal fade" id="modal-payday-date">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <input type="text" id="paydayId" value="{{$payday->id}}" hidden>
                        <input type="text" id="year" value="{{$payday->year}}" hidden>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="startDate">เริ่มวันที่ (วดป. คศ)<span
                                        class="small text-danger">*</span></label>
                                <input type="text" class="form-control input-date-format" id="startDate">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="endDate">ถึงวันที่ (วดป. คศ)<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control input-date-format" id="endDate">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>เดือน<span class="small text-danger">*</span></label>
                                <select name="paymentType" id="paymentType" class="form-control select2"
                                    style="width: 100%;">
                                    <option value="1">จ่ายสิ้นเดือน</option>
                                    <option value="2">จ่ายปลายงวด</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" id="duration_wrapper" style="display: none;">
                            <div class="form-group">
                                <label>หลังปลายงวด (วัน)<span class="small text-danger">*</span></label>
                                <input type="text" id="duration" value="7" class="form-control numericInputInt">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group float-right">
                                <button type="button" class="btn btn-primary" id="save_payday">ตกลง</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-update-payday-date">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" id="modal-update-payday-date-wrapper">

                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script type="module" src="{{asset('assets/js/helpers/salary-system/setting/payday/assignment.js?v=1')}}"></script>
<script>
    window.params = {
        storeRoute: "{{ route('groups.salary-system.setting.payday.assignment.store') }}",
        viewRoute: "{{ route('groups.salary-system.setting.payday.assignment.view') }}",
        updateRoute: "{{ route('groups.salary-system.setting.payday.assignment.update') }}",
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>
@endpush
@endsection