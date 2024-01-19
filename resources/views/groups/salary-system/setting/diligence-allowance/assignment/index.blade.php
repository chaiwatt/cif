@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">เบี้ยขยัน: {{$diligenceAllowance->name}}</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
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
                            <h4 class="card-title">รายละเอียด</h4>
                        </div>
                        <div class="card-body table-responsive p-0" id="table_container">
                            <table class="table table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        <th>เดือนที่ / Level</th>
                                        <th>เบี้ยขยัน</th>
                                        <th class="text-end">เพิ่มเติม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($diligenceAllowanceClassifies as $key => $diligenceAllowanceClassify)
                                    <tr>
                                        <td>{{$diligenceAllowanceClassify->level}}</td>
                                        <td>{{$diligenceAllowanceClassify->cost}}</td>
                                        <td class="text-end">
                                            @if ($permission->update)
                                            <a class="btn btn-primary btn-sm" href="">
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