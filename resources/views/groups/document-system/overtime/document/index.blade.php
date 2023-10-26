@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">รายการล่วงเวลา</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รายการล่วงเวลา</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <a class="btn btn-primary mb-2" href="{{route('groups.document-system.overtime.document.create')}}">
                <i class="fas fa-plus mr-1">
                </i>
                เพิ่มรายการล่วงเวลา
            </a>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card ">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>แผนก<span class="small text-danger">*</span></label>
                                        <select name="companyDepartment" id="companyDepartment"
                                            class="form-control select2 @error('prefix') is-invalid @enderror"
                                            style="width: 100%;">
                                            <option value="">===เลือกแผนก===</option>
                                            @foreach ($companyDepartments as $companyDepartment)
                                            <option value="{{ $companyDepartment->id }}">
                                                {{ $companyDepartment->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>ตั้งแต่วันที่ (วดป. คศ)<span class="small text-danger">*</span></label>
                                        <input type="text" name="startDate" id="startDate" value="{{old('startDate')}}"
                                            class="form-control input-date-format @error('startDate') is-invalid @enderror">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>ถึงวันที่ (วดป. คศ)<span class="small text-danger">*</span></label>
                                        <input type="text" name="endDate" id="endDate" value="{{old('endDate')}}"
                                            class="form-control input-date-format @error('endDate') is-invalid @enderror">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <button class="btn btn-primary float-right mr-2" id="search_overtime"><i
                                            class="fas fa-search mr-1"></i>ค้นหา</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">รายการล่วงเวลาล่าสุด</h3>
                            <ul class="nav nav-pills  float-right">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                                        aria-expanded="false">
                                        รายการที่เลือก <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" tabindex="-1" href="#" id="bulk-delete">ลบ</a>
                                        {{-- <a class="dropdown-item" tabindex="-1" href="#"
                                            id="bulk-download">ดาวน์โหลด</a> --}}
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12" id="table_container">
                                        <table class="table table-bordered table-striped dataTable dtr-inline">
                                            <thead>
                                                <tr>
                                                    <th style="width:70px">เลือก</th>
                                                    <th>วันที่</th>
                                                    <th>รายการล่วงเวลา</th>
                                                    <th>แผนก</th>
                                                    <th class="text-center">มอบหมาย</th>
                                                    <th class="text-right">เพิ่มเติม</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($overtimes as $key=> $overtime)
                                                <tr>
                                                    <td>

                                                        <div class="icheck-primary d-inline">
                                                            <input name="overtime[]" type="checkbox"
                                                                class="overtime-checkbox"
                                                                id="checkboxPrimary{{$overtime->id}}"
                                                                value="{{$overtime->id}}" @if ($overtime->status != 0)
                                                            disabled
                                                            @endif

                                                            >
                                                            <label for="checkboxPrimary{{$overtime->id}}">
                                                            </label>
                                                        </div>


                                                    </td>
                                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d',
                                                        $overtime->from_date)->format('d/m/Y') }}
                                                    </td>
                                                    <td>{{$overtime->name}}</td>
                                                    <td>{{$overtime->approver->company_department->name}}</td>

                                                    <td class="text-center">
                                                        {{count($overtime->overtimeDetails()->with('user')->get()->pluck('user')->unique())}}
                                                    </td>
                                                    <td class="text-right">
                                                        <a class="btn btn-info btn-sm"
                                                            href="{{route('groups.document-system.overtime.approval.assignment.download',['id' => $overtime->id])}}">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                        <a class="btn btn-primary btn-sm"
                                                            href="{{ route('groups.document-system.overtime.approval.assignment', ['id' => $overtime->id]) }}">
                                                            <i class="fas fa-link"></i>
                                                        </a>
                                                        @if ($overtime->status == 0)
                                                        <a class="btn btn-danger btn-sm"
                                                            data-confirm='ลบรายการล่วงเวลา "{{$overtime->name}}" หรือไม่?'
                                                            href="#" data-id="{{$overtime->id}}"
                                                            data-delete-route="{{ route('groups.document-system.overtime.document.delete', ['id' => '__id__']) }}"
                                                            data-message="รายการล่วงเวลา">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{$overtimes->links()}}
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
<script type="module" src="{{asset('assets/js/helpers/document-system/overtime/document/index.js?v=1')}}"></script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    $('.select2').select2()
    window.params = {
        searchRoute: '{{ route('groups.document-system.overtime.document.search') }}',
        bulkDeleteRoute: '{{ route('groups.document-system.overtime.document.bulk-delete') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>
@endpush
@endsection