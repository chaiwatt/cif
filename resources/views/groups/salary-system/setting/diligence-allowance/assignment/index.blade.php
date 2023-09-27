@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">เบี้ยขยัน: {{$diligenceAllowance->name}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.salary-system.setting.diligence-allowance')}}">เบี้ยขยัน</a>
                        </li>
                        <li class="breadcrumb-item active">{{$diligenceAllowance->name}}</li>
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
                            <h3 class="card-title">รายละเอียด</h3>
                        </div>
                        <div class="card-body table-responsive p-0" id="table_container">
                            <table class="table table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        <th>เดือนที่ / Level</th>
                                        <th>เบี้ยขยัน</th>
                                        <th class="text-right">เพิ่มเติม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($diligenceAllowanceClassifies as $key => $diligenceAllowanceClassify)
                                    <tr>
                                        <td>{{$diligenceAllowanceClassify->level}}</td>
                                        <td>{{$diligenceAllowanceClassify->cost}}</td>
                                        <td class="text-right">
                                            @if ($permission->update)
                                            <a class="btn btn-info btn-sm" href="">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            @endif
                                            @if ($permission->delete)
                                            <a class="btn btn-danger btn-sm">
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
            @endif

        </div>
    </div>
</div>
@push('scripts')
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
@endpush
@endsection