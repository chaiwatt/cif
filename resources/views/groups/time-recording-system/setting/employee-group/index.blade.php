@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
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
            @if ($permission->create)
            <a class="btn btn-primary mb-2"
                href="{{route('groups.time-recording-system.setting.employee-group.create')}}">
                <i class="fas fa-plus mr-1">
                </i>
                เพิ่มกลุ่มพนักงาน
            </a>
            @endif
            @if ($permission->show)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">กลุ่มพนักงาน</h4>
                        </div>
                        <div class="card-body table-responsive p-0" id="table_container">
                            <table class="table table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>กลุ่มพนักงาน</th>
                                        <th class="text-right">เพิ่มเติม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($userGroups as $key=> $userGroup)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$userGroup->name}}</td>
                                        <td class="text-right">
                                            @if ($permission->create)
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('groups.time-recording-system.setting.employee-group.assignment', ['id' => $userGroup->id]) }}">
                                                <i class="fas fa-link"></i>
                                                </i>
                                            </a>
                                            @endif
                                            @if ($permission->update)
                                            <a class="btn btn-info btn-sm"
                                                href="{{route('groups.time-recording-system.setting.employee-group.view',['id' => $userGroup->id])}}">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                            </a>
                                            @endif

                                            @if ($permission->delete == true)
                                            <a class="btn btn-danger btn-sm"
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