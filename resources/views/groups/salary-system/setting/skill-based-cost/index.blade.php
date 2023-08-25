@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">รายการค่าทักษะ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รายการค่าทักษะ</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($permission->create)
            <a class="btn btn-primary mb-2" href="{{route('groups.salary-system.setting.skill-based-cost.create')}}">
                <i class="fas fa-plus mr-1">
                </i>
                เพิ่มค่าทักษะ
            </a>
            @endif
            @if ($permission->show)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">ค่าทักษะ</h3>
                        </div>
                        <div class="card-body table-responsive p-0" id="table_container">
                            <table class="table table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ชื่อทักษะ</th>
                                        <th>มูลค่า</th>
                                        <th class="text-right">เพิ่มเติม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($skillBasedCosts as $skillBasedCost)
                                    <tr>
                                        <td>{{$skillBasedCost->name}}</td>
                                        <td>{{$skillBasedCost->cost}}</td>
                                        <td class="text-right">
                                            <a class="btn btn-info btn-sm"
                                                href="{{route('groups.salary-system.setting.skill-based-cost.view',['id' => $skillBasedCost->id])}}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm"
                                                data-confirm='ลบค่าทักษะ "{{$skillBasedCost->name}}" หรือไม่?' href="#"
                                                data-id="{{$skillBasedCost->id}}"
                                                data-delete-route="{{ route('groups.salary-system.setting.skill-based-cost.delete', ['id' => '__id__']) }}"
                                                data-message="ค่าทักษะ">
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