@extends('layouts.setting.dashboard')
@push('styles')

@endpush
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">แผนกทำงาน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">แผนกทำงาน</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <a class="btn btn-primary mb-2" href="{{route('setting.general.companydepartment.create')}}">
                <i class="fas fa-plus mr-1">
                </i>
                เพิ่มแผนก
            </a>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">รายชื่อแผนก</h3>
                        </div>
                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-bordered table-striped dataTable dtr-inline">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>รหัสแผนก</th>
                                                    <th>ชื่อแผนกภาษาไทย</th>
                                                    <th>ชื่อแผนกภาษาอังกฤษ</th>

                                                    <th class="text-right">เพิ่มเติม</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($companyDepartments as $companyDepartment)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{$companyDepartment->code}}</td>
                                                    <td>{{$companyDepartment->name}}</td>
                                                    <td>{{$companyDepartment->eng_name}}</td>

                                                    <td class="text-right">
                                                        <a class="btn btn-info btn-sm"
                                                            href="{{ route('setting.general.companydepartment.view', ['id' => $companyDepartment->id]) }}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <a class="btn btn-danger btn-sm"
                                                            data-confirm='ลบแผนก "{{$companyDepartment->name}}" หรือไม่?'
                                                            href="#" data-id="{{$companyDepartment->id}}"
                                                            data-delete-route="{{ route('setting.general.companydepartment.delete', ['id' => '__id__']) }}"
                                                            data-message="แผนก">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="{{asset('assets/js/helper/helper.js?v=1')}}"></script>
@endpush
@endsection