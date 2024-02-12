@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="title-header">
                <div>
                    <h3 class="m-0">อนุมัติล่วงเวลา</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รายการล่วงเวลา</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">ค้นหา</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>แผนก</label>
                                <select name="companyDepartment" id="companyDepartment"
                                    class="form-control select2 @error('companyDepartment') is-invalid @enderror"
                                    style="width: 100%;">
                                    @foreach ($companyDepartments as $companyDepartment)
                                    <option value="{{ $companyDepartment->id }}" {{
                                        old('companyDepartment')==$companyDepartment->id
                                        ?
                                        'selected' : '' }}>
                                        {{ $companyDepartment->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>เดือน</label>
                                <select name="month" id="month"
                                    class="form-control select2 @error('month') is-invalid @enderror"
                                    style="width: 100%;">
                                    @foreach ($months as $month)
                                    <option value="{{ $month->id }}" {{ old('month')==$month->id
                                        ?
                                        'selected' : '' }}>
                                        {{ $month->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>ปี</label>
                                <select name="month" id="year"
                                    class="form-control select2 @error('year') is-invalid @enderror"
                                    style="width: 100%;">
                                    @foreach ($years as $year)
                                    <option value="{{ $year }}" {{ old('year')==$year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>อื่น ๆ </label>
                                    <input type="text" name="search_string" id="search_string"
                                        value="{{old('search_string')}}" class="form-control"
                                        placeholder="รหัสพนักงาน,ชื่อ,สกุล,สายอนุมัติ">
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-end mt-2">
                            <button class="btn btn-primary d-flex gap-2 align-items-center" id="search_overtime">
                                <i class="fas fa-search"></i>ค้นหา
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">รายการล่วงเวลาล่าสุด</h3>
                        </div>
                        <div>
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12 table-responsive" id="table_container">
                                        <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                            <thead class="border-bottom">
                                                <tr>
                                                    <th>รายการล่วงเวลา</th>
                                                    <th>วันที่</th>
                                                    <th>ผู้อนุมัติเอกสาร</th>
                                                    <th>สถานะ</th>
                                                    <th class="text-end">เพิ่มเติม</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="module" src="{{asset('assets/js/helpers/document-system/overtime/approval.js?v=1')}}"></script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    $('.select2').select2()
    window.params = {
        overtimeApprovalRoute: '{{ route('groups.document-system.overtime.approval.overtime-approval') }}',
        searchRoute: '{{ route('groups.document-system.overtime.approval.search') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>
@endpush
@endsection