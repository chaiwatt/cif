@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">ค่าทักษะ</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">ค่าทักษะ</li>
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
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">ค่าทักษะ</h4>
                            @if ($permission->create)
                                <a class="btn btn-header" href="{{route('groups.salary-system.setting.skill-based-cost.create')}}">
                                    <i class="fas fa-plus"></i>
                                    เพิ่มค่าทักษะ
                                </a>
                             @endif
                        </div>
                        <div class="card-body table-responsive py-0 px-3" id="table_container">
                            <table class="table table-borderless text-nowrap">
                                <thead class="border-bottom">
                                    <tr>
                                        <th>ชื่อทักษะ</th>
                                        <th>มูลค่า</th>
                                        <th class="text-end">เพิ่มเติม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($skillBasedCosts as $skillBasedCost)
                                    <tr>
                                        <td>{{$skillBasedCost->name}}</td>
                                        <td>{{$skillBasedCost->cost}}</td>
                                        <td class="text-end">
                                            @if ($permission->update)
                                            <a class="btn btn-action btn-edit btn-sm"
                                                href="{{route('groups.salary-system.setting.skill-based-cost.view',['id' => $skillBasedCost->id])}}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            @endif

                                            @if ($permission->delete)
                                            <a class="btn btn-action btn-delete btn-sm"
                                                data-confirm='ลบค่าทักษะ "{{$skillBasedCost->name}}" หรือไม่?' href="#"
                                                data-id="{{$skillBasedCost->id}}"
                                                data-delete-route="{{ route('groups.salary-system.setting.skill-based-cost.delete', ['id' => '__id__']) }}"
                                                data-message="ค่าทักษะ">
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