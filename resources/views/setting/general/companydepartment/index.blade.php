@extends('layouts.setting-dashboard')
@push('styles')

@endpush
@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">แผนกทำงาน</h3>
                </div>
                <div>
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">รายชื่อแผนก</h3>
                            <a class="btn btn-header" href="{{route('setting.general.companydepartment.create')}}">
                                <i class="fas fa-plus">
                                </i>
                                เพิ่มแผนก
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12 table-responsive">
                                        <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                            <thead class="border-bottom">
                                                <tr>
                                                    <th>#</th>
                                                    <th>รหัสแผนก</th>
                                                    <th>ชื่อแผนกภาษาไทย</th>
                                                    <th>ชื่อแผนกภาษาอังกฤษ</th>

                                                    <th class="text-end">เพิ่มเติม</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($companyDepartments as $companyDepartment)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{$companyDepartment->code}}</td>
                                                    <td>{{$companyDepartment->name}}</td>
                                                    <td>{{$companyDepartment->eng_name}}</td>

                                                    <td class="text-end">
                                                        <a class="btn btn-action btn-edit btn-sm"
                                                            href="{{ route('setting.general.companydepartment.view', ['id' => $companyDepartment->id]) }}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <a class="btn btn-action btn-delete btn-sm"
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
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
@endpush
@endsection
