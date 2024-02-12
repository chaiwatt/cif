@extends('layouts.setting-dashboard')
@push('styles')

@endpush
@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="title-header">
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">สายอนุมัติ</h4>
                            <a class="btn btn-header" href="{{route('setting.organization.approver.create')}}">
                                <i class="fas fa-plus">
                                </i>
                                เพิ่มสายอนุมัติ
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12" id="table_container">
                                        <div class="table-responsive">
                                            <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                                <thead class="border-bottom">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>สายอนุมัติ</th>
                                                        <th>แผนก</th>
                                                        <th>ประเภทเอกสาร</th>
                                                        <th>ผู้อนุมัติลำดับที่ 1</th>
                                                        <th>ผู้อนุมัติลำดับที่ 2</th>
                                                        <th class="text-end">เพิ่มเติม</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
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
                                                        <td class="text-end">

                                                            <a class="btn btn-action btn-links btn-sm"
                                                                href="{{route('setting.organization.approver.assignment.index',['id' => $approver->id])}}">
                                                                <i class="fas fa-link"></i>
                                                            </a>
                                                            <a class="btn btn-action btn-edit btn-sm"
                                                                href="{{route('setting.organization.approver.view',['id' => $approver->id])}}">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                            <a class="btn btn-action btn-delete btn-sm"
                                                                data-confirm='ลบสายอนุมัติ "{{$approver->name}} {{$approver->lastname}}" หรือไม่?'
                                                                href="#" data-id="{{$approver->id}}"
                                                                data-delete-route="{{ route('setting.organization.approver.delete', ['id' => '__id__']) }}"
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