@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">รายการพนักงาน</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รายการพนักงาน</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($permission->show)
            <a class="btn btn-primary mb-2" href="" id="btn-show-modal-income-deduct-assignment">
                <i class="fas fa-plus me-1">
                </i>
                เพิ่มรายการเงินได้เงินหัก
            </a>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">รายการพนักงาน</h4>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="search_query" id="search_query"
                                        class="form-control" placeholder="ค้นหา">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12" id="table_container">
                                        <table class="table table-bordered table-striped dataTable dtr-inline"
                                            id="userTable">
                                            <thead>
                                                <tr>
                                                    <th>รหัสพนักงาน</th>
                                                    <th>ชื่อ-สกุล</th>
                                                    <th>รอบเงินเดือน</th>
                                                    <th>เงินได้ / เงินหัก</th>
                                                    {{-- <th>ประเภท</th> --}}
                                                    {{-- <th>จำนวน</th> --}}
                                                    <th>แผนก</th>
                                                    <th class="text-end">เพิ่มเติม</th>
                                                </tr>
                                            </thead>
                                            <tbody id="employee_tbody">
                                                @foreach ($incomeDeductUsers as $key => $incomeDeductUser)
                                                <tr>
                                                    @php
                                                    $incomeDeductByUsers =
                                                    $incomeDeductUser->user->getIncomeDeductByUsers()
                                                    @endphp
                                                    <td>{{$incomeDeductUser->user->employee_no}}</td>
                                                    <td>{{$incomeDeductUser->user->prefix->name}}{{$incomeDeductUser->user->name}}
                                                        {{$incomeDeductUser->user->lastname}}</td>
                                                    <td>{{$incomeDeductUser->user->getPaydayWithToday()->name}}</td>
                                                    {{-- <td>{{$incomeDeductByUsers}}</td> --}}
                                                    <td>
                                                        @if (count($incomeDeductByUsers) != 0)
                                                        <ul class="mb-0">
                                                            @foreach ($incomeDeductByUsers as $incomeDeductByUser)
                                                            <li>{{$incomeDeductByUser->incomeDeduct->name}}
                                                                {{$incomeDeductByUser->value}}
                                                                {{$incomeDeductByUser->incomeDeduct->unit->name}}</li>
                                                            @endforeach
                                                        </ul>
                                                        @endif
                                                    </td>
                                                    <td>{{$incomeDeductUser->user->company_department->name}}</td>
                                                    {{-- <td></td> --}}

                                                    <td class="text-end">
                                                        <a class="btn btn-danger btn-sm btn-delete" href=""
                                                            data-id="{{$incomeDeductUser->user->id}}">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{ $incomeDeductUsers->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
    <div class="modal fade" id="modal-income-deduct-assignment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>เงินได้ / เงินหัก <span class="fw-bold text-danger">*</span></label>
                                <select id="incomeDeduct" class="form-control select2 " style="width: 100%;">
                                    <option value="">==เลือกรายการเงินได้ / เงินหัก==</option>
                                    @foreach ($incomeDeducts as $incomeDeduct)
                                    <option value="{{ $incomeDeduct->id }}">
                                        {{ $incomeDeduct->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="employee-code">รหัสพนักงานแถวละ 1 รายการ</label>
                                <textarea class="form-control" id="employee-code" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-end">
                            <button type="button" class="btn btn-primary"
                                id="btn-import-employee-code">เพิ่มรายการ</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="module" src="{{asset('assets/js/helpers/salary-system/salary/income-deduct-assignment/index.js?v=1')}}">
</script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>

<script>
    $('.select2').select2()
    window.params = {
        storeRoute: '{{ route('groups.salary-system.salary.income-deduct-assignment.store') }}',
        deleteRoute: '{{ route('groups.salary-system.salary.income-deduct-assignment.delete') }}',
        searchRoute: '{{ route('groups.salary-system.salary.income-deduct-assignment.search') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection