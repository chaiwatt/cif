@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="title-header">
                <div>
                    <h3 class="m-0">กลุ่มพนักงาน</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">กลุ่มพนักงาน</li>
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
                        <div class="card-header card-sm">
                            <h4 class="card-title">กลุ่มพนักงาน</h4>
                            @if ($permission->create)
                            <a class="btn btn-header"
                                href="{{route('groups.time-recording-system.setting.employee-group.create')}}">
                                <i class="fas fa-plus">
                                </i>
                                เพิ่มกลุ่มพนักงาน
                            </a>
                            @endif
                        </div>
                        <div class="table-responsive" id="table_container">
                            <table class="table table-borderless text-nowrap">
                                <thead class="border-bottom">
                                    <tr>
                                        <th>#</th>
                                        <th>กลุ่มพนักงาน</th>
                                        <th class="text-end">เพิ่มเติม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($userGroups as $key=> $userGroup)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$userGroup->name}}</td>
                                        <td class="text-end">
                                            @if ($permission->create)
                                            <a class="btn btn-action btn-links btn-sm"
                                                href="{{ route('groups.time-recording-system.setting.employee-group.assignment', ['id' => $userGroup->id]) }}">
                                                <i class="fas fa-link"></i>
                                                </i>
                                            </a>
                                            @endif
                                            @if ($permission->update)
                                            <a class="btn btn-action btn-edit btn-sm"
                                                href="{{route('groups.time-recording-system.setting.employee-group.view',['id' => $userGroup->id])}}">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                            </a>
                                            @endif

                                            @if ($permission->delete == true)
                                            <a class="btn btn-action btn-delete btn-sm"
                                                data-confirm='ลบกลุ่มพนักงาน "{{$userGroup->name}}" หรือไม่?' href="#"
                                                data-id="{{$userGroup->id}}"
                                                data-delete-route="{{ route('groups.time-recording-system.setting.employee-group.delete', ['id' => '__id__']) }}"
                                                data-message="กลุ่มพนักงาน">
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