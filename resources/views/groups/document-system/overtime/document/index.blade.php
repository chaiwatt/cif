@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">รายการล่วงเวลา</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รายการล่วงเวลา</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <a class="btn btn-primary mb-2" href="{{route('groups.document-system.overtime.document.create')}}">
                <i class="fas fa-plus mr-1">
                </i>
                เพิ่มรายการล่วงเวลา
            </a>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">รายการล่วงเวลาล่าสุด</h3>
                        </div>
                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12" id="table_container">
                                        <table class="table table-bordered table-striped dataTable dtr-inline">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>รายการล่วงเวลา</th>
                                                    <th>วันที่</th>
                                                    <th>เวลา</th>
                                                    <th class="text-right">เพิ่มเติม</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($overtimes as $key=> $overtime)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$overtime->name}}</td>
                                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d',
                                                        $overtime->from_date)->format('d/m/Y') }}
                                                        - {{ \Carbon\Carbon::createFromFormat('Y-m-d',
                                                        $overtime->to_date)->format('d/m/Y') }}</td>
                                                    <td>{{ substr($overtime->start_time, 0, 5) }} - {{
                                                        substr($overtime->end_time, 0, 5) }}</td>
                                                    <td class="text-right">
                                                        <a class="btn btn-primary btn-sm"
                                                            href="{{ route('groups.document-system.overtime.approval.assignment', ['id' => $overtime->id]) }}">
                                                            <i class="fas fa-link"></i>
                                                        </a>
                                                        <a class="btn btn-info btn-sm"
                                                            href="{{route('groups.document-system.overtime.document.view',['id' => $overtime->id])}}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <a class="btn btn-danger btn-sm"
                                                            data-confirm='ลบรายการล่วงเวลา "{{$overtime->name}}" หรือไม่?'
                                                            href="#" data-id="{{$overtime->id}}"
                                                            data-delete-route="{{ route('groups.document-system.overtime.document.delete', ['id' => '__id__']) }}"
                                                            data-message="รายการล่วงเวลา">
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
<script type="module" src="{{asset('assets/js/helpers/document-system/leave/document.js?v=1')}}"></script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    $('.select2').select2()
    window.params = {
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>
@endpush
@endsection