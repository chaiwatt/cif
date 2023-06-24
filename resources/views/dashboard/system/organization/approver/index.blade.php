@extends('layouts.setting.dashboard')
@push('styles')

@endpush
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">รายการอนุมัติ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รายการอนุมัติ</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <a class="btn btn-primary mb-2" href="{{route('setting.organization.approver.create')}}">
                <i class="fas fa-plus mr-1">
                </i>
                เพิ่มรายการอนุมัติ
            </a>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">รายการอนุมัติ</h3>
                        </div>
                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12" id="table_container">
                                        <table class="table table-bordered table-striped dataTable dtr-inline">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>การอนุมัติ</th>
                                                    <th>แผนก</th>
                                                    <th>ประเภทเอกสาร</th>
                                                    <th>ผู้อนุมัติลำดับที่ 1</th>
                                                    <th>ผู้อนุมัติลำดับที่ 2</th>
                                                    <th class="text-right">เพิ่มเติม</th>
                                                </tr>
                                            </thead>
                                            <tbody id="approver_tbody">
                                                @foreach ($approvers as $key=> $approver)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$approver->name}}</td>
                                                    <td>{{$approver->company_department->name}}</td>
                                                    <td>{{$approver->document_type->name}}</td>
                                                    <td>{{$approver->approver_one->name}}
                                                        {{$approver->approver_one->lastname}}</td>
                                                    <td>@if ($approver->approver_two)
                                                        {{$approver->approver_two->name}}
                                                        {{$approver->approver_two->lastname}}
                                                        @endif
                                                    </td>
                                                    <td class="text-right">

                                                        <a class="btn btn-primary btn-sm"
                                                            href="{{route('setting.organization.approver.assignment.index',['id' => $approver->id])}}">
                                                            <i class="fas fa-link"></i>
                                                        </a>
                                                        <a class="btn btn-info btn-sm"
                                                            href="{{route('setting.organization.approver.view',['id' => $approver->id])}}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <a class="btn btn-danger btn-sm"
                                                            data-confirm='ลบรายการอนุมัติ "{{$approver->name}} {{$approver->lastname}}" หรือไม่?'
                                                            href="#" data-id="{{$approver->id}}"
                                                            data-delete-route="{{ route('setting.organization.approver.delete', ['id' => '__id__']) }}"
                                                            data-message="รายการอนุมัติ">
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
<script>
    window.params = {
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>
@endpush
@endsection