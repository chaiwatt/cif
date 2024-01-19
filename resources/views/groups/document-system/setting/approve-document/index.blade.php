@extends('layouts.dashboard')

@section('content')
@push('styles')

@endpush
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">สายอนุมัติ</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">สายอนุมัติ</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <a class="btn btn-primary mb-2" href="{{route('groups.document-system.setting.approve-document.create')}}">
                <i class="fas fa-plus mr-1">
                </i>
                เพิ่มสายอนุมัติ
            </a>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">สายอนุมัติ</h4>
                        </div>
                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12" id="table_container">
                                        <table class="table table-bordered table-striped dataTable dtr-inline">
                                            <thead>
                                                <tr>
                                                    <th>รหัส</th>
                                                    <th>สายอนุมัติ</th>
                                                    <th>แผนก</th>
                                                    <th>ประเภทเอกสาร</th>
                                                    <th>ผู้จัดการ</th>
                                                    <th>หัวหน้างาน</th>
                                                    <th class="text-right">เพิ่มเติม</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($approvers as $key=> $approver)
                                                <tr>
                                                    <td>{{$approver->code}}</td>
                                                    <td>{{$approver->name}}</td>
                                                    <td>{{$approver->company_department->name}}</td>
                                                    <td>{{$approver->document_type->name}}</td>
                                                    <td>{{$approver->user->name}} {{$approver->user->lastname}}</td>
                                                    <td>
                                                        @foreach ($approver->authorizedUsers as $user)
                                                        {{$user->name}} {{$user->lastname}} <br>
                                                        @endforeach
                                                    </td>
                                                    <td class="text-right">

                                                        <a class="btn btn-primary btn-sm"
                                                            href="{{route('groups.document-system.setting.approve-document.assignment.index',['id' => $approver->id])}}">
                                                            <i class="fas fa-link"></i>
                                                        </a>
                                                        <a class="btn btn-info btn-sm"
                                                            href="{{route('groups.document-system.setting.approve-document.view',['id' => $approver->id])}}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <a class="btn btn-danger btn-sm"
                                                            data-confirm='ลบสายอนุมัติ "{{$approver->name}} {{$approver->lastname}}" หรือไม่?'
                                                            href="#" data-id="{{$approver->id}}"
                                                            data-delete-route="{{ route('groups.document-system.setting.approve-document.delete', ['id' => '__id__']) }}"
                                                            data-message="สายอนุมัติ">
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
<script>
    window.params = {
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>
@endpush
@endsection