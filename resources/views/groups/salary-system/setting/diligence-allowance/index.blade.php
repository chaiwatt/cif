@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">รายการเบี้ยขยัน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รายการเบี้ยขยัน</li>
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
                            <h3 class="card-title">รายการเบี้ยขยัน</h3>
                        </div>
                        <div class="card-body table-responsive p-0" id="table_container">
                            <table class="table table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>รายการเบี้ยขยัน</th>
                                        <th class="text-right">เพิ่มเติม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($diligenceAllowances as $key => $diligenceAllowance)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$diligenceAllowance->name}}</td>
                                        <td class="text-right">
                                            <a class="btn btn-primary btn-sm"
                                                href="{{route('groups.salary-system.setting.diligence-allowance.assignment',['id' => $diligenceAllowance->id])}}">
                                                <i class="fas fa-link"></i>
                                            </a>
                                            <a class="btn btn-info btn-sm"
                                                href="{{route('groups.salary-system.salary.diligence-allowance.view',['id' => $diligenceAllowance->id])}}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm"
                                                data-confirm='ลบรายการเบี้ยขยัน "{{$diligenceAllowance->name}}" หรือไม่?'
                                                href="#" data-id="{{$diligenceAllowance->id}}"
                                                data-delete-route="{{ route('groups.salary-system.salary.diligence-allowance.delete', ['id' => '__id__']) }}"
                                                data-message="รายการเบี้ยขยัน">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
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
</div>
@push('scripts')
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>

@endpush
@endsection