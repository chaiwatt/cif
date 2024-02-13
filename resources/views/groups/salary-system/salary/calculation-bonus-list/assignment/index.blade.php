@extends('layouts.dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/loading.css?v=1.0') }}">
@endpush
<div>
    @include('layouts.partial.loading')
    <div>
        <div class="container-fluid">
            <div class="title-header">
                <div>
                    <h3 class="m-0">เพิ่มเงินโบนัสประจำปี</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('groups.salary-system.salary.calculation-bonus-list')}}">เงินโบนัสประจำปี</a>
                        </li>
                        <li class="breadcrumb-item active">เพิ่มเงินโบนัสประจำปี</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($permission->show)

            <div class="row">
                <div class="col-12" id="content_wrapper">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">รายการลาล่าสุด</h4>
                            <div class="d-flex gap-2">
                                @if ($bonus->status == 0)
                                <a class="btn btn-header" id="import-employee-code">
                                    <i class="fas fa-plus">
                                    </i>
                                    เพิ่มรายการเงินโบนัส
                                </a>
                                @endif
                                <div class="card-tools search">
                                    <input type="text" name="search_query" id="search_query"
                                        class="form-control" placeholder="ค้นหา">
                                    <label for="search_query">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="23" viewBox="0 0 22 23" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.0833 4.39585C6.66608 4.39585 3.89584 7.16609 3.89584 10.5834C3.89584 14.0006 6.66608 16.7709 10.0833 16.7709C11.7446 16.7709 13.2529 16.1162 14.3644 15.0507C14.3915 15.0167 14.4208 14.9838 14.4523 14.9523C14.4838 14.9208 14.5167 14.8915 14.5507 14.8644C15.6162 13.7529 16.2708 12.2446 16.2708 10.5834C16.2708 7.16609 13.5006 4.39585 10.0833 4.39585ZM16.8346 15.7141C17.9188 14.2897 18.5625 12.5117 18.5625 10.5834C18.5625 5.90044 14.7663 2.10419 10.0833 2.10419C5.40042 2.10419 1.60417 5.90044 1.60417 10.5834C1.60417 15.2663 5.40042 19.0625 10.0833 19.0625C12.0117 19.0625 13.7896 18.4188 15.2141 17.3346L18.4398 20.5602C18.8873 21.0077 19.6128 21.0077 20.0602 20.5602C20.5077 20.1128 20.5077 19.3873 20.0602 18.9398L16.8346 15.7141Z" fill="#475467"/>
                                            </svg>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <input type="text" id="bonusId" value="{{$bonus->id}}" hidden>
                                <div class="col-sm-12" id="table_container">
                                    <div class="table-responsive">
                                        <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                            <thead class="border-bottom">
                                                <tr>
                                                    <th>พนักงาน</th>
                                                    <th>แผนก</th>
                                                    <th style="width: 300px">โบนัส</th>
                                                    @if ($bonus->status == 0)
                                                    <th class="text-end" style="width: 100px">เพิ่มเติม
                                                    </th>
                                                    @endif

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($bonusUsers as $key=> $bonusUser)
                                                <tr>
                                                    <td>{{$bonusUser->user->name}} {{$bonusUser->user->lastname}}</td>
                                                    <td>{{$bonusUser->user->company_department->name}}</td>
                                                    <td>
                                                        <input type="text" name="description" data-id="{{$bonusUser->id}}"
                                                            value="{{$bonusUser->cost}}"
                                                            class="form-control decimal-input bonus" @if ($bonus->status ==
                                                        1) readonly @endif>
                                                    </td>
                                                    @if ($bonus->status == 0)
                                                    <td class="text-end">
                                                        <a class="btn btn-action btn-delete btn-sm delete" href=""
                                                            data-id="{{$bonusUser->id}}">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                    @endif

                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{$bonusUsers->links()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @endif
        </div>
        <div class="modal fade" id="modal-import-employee-code">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 600px;">
                <div class="modal-content" style="height: 600px;">
                    <div class="cif-modal-body">
                        <label for="employee-code" class="h5">รหัสพนักงานและเงินโบนัสแถวละ 1 รายการ</label>
                        <textarea class="form-control number" id="employee-code" rows="18"></textarea>
                    </div>
                    <div class="cif-modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="button" class="btn btn-primary" id="btn-import-employee-code">เพิ่มรายการ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')

<script type="module"
    src="{{ asset('assets/js/helpers/salary-system/salary/calculation-bonus-list/assignment.js?v=1') }}">
</script>

<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>

<script>
    window.params = {
        searchRoute: '{{ route('groups.salary-system.salary.calculation-bonus-list.assignment.search') }}',
        deleteRoute: '{{ route('groups.salary-system.salary.calculation-bonus-list.assignment.delete') }}',
        importRoute: '{{ route('groups.salary-system.salary.calculation-bonus-list.assignment.import') }}',
        updateBonusRoute: '{{ route('groups.salary-system.salary.calculation-bonus-list.assignment.update-bonus') }}',
        
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>


@endpush
@endsection