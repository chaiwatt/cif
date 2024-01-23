@extends('layouts.setting-dashboard')
@push('styles')

@endpush
@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">สายอนุมัติ: {{$approver->name}}</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{route('setting.organization.approver.index')}}">สายอนุมัติ</a></li>
                        <li class="breadcrumb-item active">{{$approver->name}}</li>
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
                            <h4 class="card-title">รายการพนักงานใน {{$approver->name}}</h4>
                            <a class="btn btn-header"
                                href="{{route('setting.organization.approver.assignment.create',['id' => $approver->id])}}">
                                <i class="fas fa-plus">
                                </i>
                                เพิ่มพนักงาน
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
                                                    <th>รหัสพนักงาน</th>
                                                    <th>ชื่อ-สกุล</th>
                                                    <th>แผนก</th>
                                                    <th class="text-end">เพิ่มเติม</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($approver->users as $key => $user)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$user->employee_no}}</td>
                                                    <td>{{$user->name}} {{$user->lastname}}</td>
                                                    <td>{{$user->company_department->name}}</td>
                                                    <td class="text-end">
                                                        <form
                                                            action="{{ route('setting.organization.approver.assignment.delete', ['approver_id' => $approver->id, 'user_id' => $user->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-delete btn-action btn-sm" type="submit"><i
                                                                    class="fas fa-trash"></i></button>
                                                        </form>
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