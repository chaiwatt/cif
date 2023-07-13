@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">กลุ่มพนักงาน {{$userGroup->name}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.time-recording-system.setting.employee-group')}}">กลุ่มพนักงาน</a>
                        </li>
                        <li class="breadcrumb-item active">{{$userGroup->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($permission->create)
            <a class="btn btn-primary mb-2"
                href="{{route('groups.time-recording-system.setting.employee-group.assignment.create',['id' => $userGroup->id])}}">
                <i class="fas fa-plus mr-1">
                </i>
                เพิ่มพนักงาน
            </a>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">พนักงาน</h3>
                        </div>
                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12" id="table_container">
                                        <table class="table table-bordered table-striped dataTable dtr-inline">
                                            <thead>
                                                <tr>
                                                    <th>เลือก</th>
                                                    <th>รหัสพนักงาน</th>
                                                    <th>ชื่อ-สกุล</th>
                                                    <th>แผนก</th>
                                                    <th class="text-right">เพิ่มเติม</th>
                                                </tr>
                                            </thead>
                                            <tbody id="employee_tbody">
                                                @foreach ($users as $key => $user)
                                                <tr>
                                                    <td>{{$key +1}}</td>
                                                    <td>{{$user->employee_no}}</td>
                                                    <td>{{$user->prefix->name}}{{$user->name}} {{$user->lastname}}
                                                    </td>
                                                    <td>{{$user->company_department->name}}</td>
                                                    <td class="text-right">
                                                        <form
                                                            action="{{ route('groups.time-recording-system.setting.employee-group.assignment.delete', ['user_group_id' => $userGroup->id, 'user_id' => $user->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger btn-sm" type="submit"><i
                                                                    class="fas fa-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{ $users->links() }}
                                    </div>
                                </div>
                            </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')

<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>

@endpush
@endsection