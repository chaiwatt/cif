@extends('layouts.dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/loading.css?v=1.0') }}">
@endpush
<div>
    @include('layouts.partial.loading')
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">เงินโบนัสประจำปี</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a>
                        </li>
                        <li class="breadcrumb-item active">เงินโบนัสประจำปี</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($permission->show)
            <a class="btn btn-primary mb-2"
                href="{{route('groups.salary-system.salary.calculation-bonus-list.create')}}">
                <i class="fas fa-plus mr-1">
                </i>
                เพิ่มรายการเงินโบนัส
            </a>
            <div class="row">
                <div class="col-12" id="content_wrapper">
                    <div class="card card-primary card-outline card-tabs">
                        <div class="card-header p-0 pt-1 border-bottom-0">
                            <div class="card-tools mt-2">
                                {{-- <div class="input-group input-group-sm mt-1" style="width: 150px;">
                                    <select name="year" id="year" class="form-control " style="width: 100%;">
                                        @foreach ($years as $year)
                                        <option value="{{ $year}}" @if ($year==$selectedYear) selected @endif>
                                            {{ $year }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12" id="table_container">
                                    <table class="table table-bordered table-striped dataTable dtr-inline">
                                        <thead>
                                            <tr>
                                                <th style="width: 200px">วันที่</th>
                                                <th>ชื่อรายการ</th>
                                                <th style="width: 200px">สถานะ</th>
                                                <th class="text-end" style="width: 200px">เพิ่มเติม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bonuses as $key=> $bonus)

                                            <tr>
                                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d',
                                                    $bonus->issued)->format('d/m/Y') }}</td>
                                                <td>{{$bonus->name}}</td>
                                                <td>@if($bonus->status == 0)
                                                    <span class="badge bg-success">ใช้งาน</span>
                                                    @elseif($bonus->status == 1)
                                                    <span class="badge bg-gray">ปิดงวด</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <a class="btn btn-success btn-sm"
                                                        href="{{route('groups.salary-system.salary.calculation-bonus-list.download-pdf',['id' => $bonus->id])}}">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{route('groups.salary-system.salary.calculation-bonus-list.assignment',['id' =>$bonus->id])}}">
                                                        <i class="fas fa-link"></i>
                                                    </a>
                                                    <a class="btn btn-info btn-sm"
                                                        href="{{route('groups.salary-system.salary.calculation-bonus-list.view',['id' => $bonus->id])}}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    @if ($bonus->status == 0)
                                                    <a class="btn btn-danger btn-sm"
                                                        data-confirm='ลบรายโบนัส "{{$bonus->name}}" หรือไม่?' href="#"
                                                        data-id="{{$bonus->id}}"
                                                        data-delete-route="{{ route('groups.salary-system.salary.calculation-bonus-list.delete', ['id' => '__id__']) }}"
                                                        data-message="รายโบนัส">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    @endif

                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')


<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>


@endpush
@endsection