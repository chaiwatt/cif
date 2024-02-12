@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="title-header">
                <div>
                    <h3 class="m-0">นำเข้าพนักงาน {{$overtime->name}}</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('groups.document-system.overtime.approval.assignment', ['id' => $overtime->id]) }}">รายการล่วงเวลา</a>
                        </li>
                        <li class="breadcrumb-item active">{{$overtime->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <h5><i class="icon fas fa-ban"></i> ผิดพลาด</h5>
                {{ $errors->first() }}
            </div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">รายชื่อพนักงาน</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="search_query" id="search_query"
                                        class="form-control float-right" placeholder="ค้นหา">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <form action="{{route('groups.document-system.overtime.approval.assignment.store')}}"
                                method="POST">
                                @csrf
                                <input name="overtimeId" id="overtimeId" value="{{$overtime->id}}" type="text" hidden>
                                <div class="dataTables_wrapper dt-bootstrap4">
                                    <div class="row">
                                        <div class="col-sm-12 table-responsive" id="table_container">
                                            <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                                <thead class="border-bottom">
                                                    <tr>
                                                        <th>เลือก</th>
                                                        <th>รหัสพนักงาน</th>
                                                        <th>ชื่อ-สกุล</th>
                                                        <th>แผนก</th>
                                                        <th>ตำแหน่ง</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="employee_tbody">
                                                    @foreach ($users as $user)
                                                    <tr>
                                                        <td>
                                                            <div class="icheck-primary d-inline">
                                                                <input name="users[]" type="checkbox"
                                                                    id="checkboxPrimary{{$user->id}}"
                                                                    value="{{$user->id}}">
                                                                <label for="checkboxPrimary{{$user->id}}">
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>{{$user->employee_no}}</td>
                                                        <td>{{$user->prefix->name}}{{$user->name}} {{$user->lastname}}
                                                        </td>
                                                        <td>{{$user->company_department->name}}</td>
                                                        <td>{{$user->user_position->name}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $users->links() }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-primary">บันทึก</button>
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

<script type="module" src="{{asset('assets/js/helpers/document-system/overtime/assignment/overtime.js?v=1')}}"></script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        searchRoute: '{{ route('groups.document-system.overtime.approval.assignment.search') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>
@endpush
@endsection