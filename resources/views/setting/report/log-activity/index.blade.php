@extends('layouts.setting-dashboard')
@push('styles')

@endpush
@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">ประวัติใช้งาน (Log)</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">ประวัติใช้งาน (Log)</li>
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
                            <h3 class="card-title m-0">ประวัติใช้งาน</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="search_query" id="search_query"
                                        class="form-control float-right" placeholder="ค้นหา">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12" id="table_container">
                                        <table class="table table-bordered table-striped dataTable dtr-inline"
                                            id="userTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>วันที่</th>
                                                    <th>ชื่อ-สกุล</th>
                                                    <th>แอคชั่น</th>
                                                    <th>โมเดล</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($logActivities as $key => $logActivity)
                                                <tr>
                                                    <td>{{($key + 1 + $logActivities->perPage() *
                                                        ($logActivities->currentPage() - 1))}}
                                                    </td>
                                                    <td>{{ $logActivity->created_at->format('d-m-Y H:i') }}</td>
                                                    <td>{{$logActivity->user->name}} {{$logActivity->user->lastname}}
                                                    </td>
                                                    <td>{{$logActivity->action}}</td>
                                                    <td>{{$logActivity->model}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{ $logActivities->links() }}
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

<script type="module" src="{{asset('assets/js/helpers/setting/report/log-activity/log-activity.js?v=1')}}"></script>

<script>
    window.params = {
        searchRoute: '{{ route('setting.report.log.search') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection