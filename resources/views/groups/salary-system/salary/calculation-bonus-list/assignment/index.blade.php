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
                    <div class="card card-primary card-outline">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">รายการลาล่าสุด</h4>
                            <div class="d-flex gap-2">
                                @if ($bonus->status == 0)
                                <a class="btn btn-header" id="import-employee-code">
                                    <i class="fas fa-plus">
                                    </i>
                                    เพิ่มรายการเงินโบนัส
                                </a>
                                @endif
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="search_query" id="search_query"
                                            class="form-control" placeholder="ค้นหา">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <input type="text" id="bonusId" value="{{$bonus->id}}" hidden>
                                <div class="col-sm-12 table-responsive" id="table_container">
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
            @endif
        </div>
        <div class="modal fade" id="modal-import-employee-code">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="employee-code">รหัสพนักงานและเงินโบนัสแถวละ 1 รายการ</label>
                                    <textarea class="form-control number" id="employee-code" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-end mt-2">
                                <button type="button" class="btn btn-primary"
                                    id="btn-import-employee-code">เพิ่มรายการ</button>
                            </div>
                        </div>
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