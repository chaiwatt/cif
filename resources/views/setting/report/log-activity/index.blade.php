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
                        <div class="card-header">
                            <h3 class="card-title">ประวัติใช้งาน</h3>
                            <div class="card-tools search">
                                <input type="text" name="search_query" id="search_query"
                                    class="form-control" placeholder="ค้นหา...">
                                    <label for="search_query">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="23" viewBox="0 0 22 23" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.0833 4.39585C6.66608 4.39585 3.89584 7.16609 3.89584 10.5834C3.89584 14.0006 6.66608 16.7709 10.0833 16.7709C11.7446 16.7709 13.2529 16.1162 14.3644 15.0507C14.3915 15.0167 14.4208 14.9838 14.4523 14.9523C14.4838 14.9208 14.5167 14.8915 14.5507 14.8644C15.6162 13.7529 16.2708 12.2446 16.2708 10.5834C16.2708 7.16609 13.5006 4.39585 10.0833 4.39585ZM16.8346 15.7141C17.9188 14.2897 18.5625 12.5117 18.5625 10.5834C18.5625 5.90044 14.7663 2.10419 10.0833 2.10419C5.40042 2.10419 1.60417 5.90044 1.60417 10.5834C1.60417 15.2663 5.40042 19.0625 10.0833 19.0625C12.0117 19.0625 13.7896 18.4188 15.2141 17.3346L18.4398 20.5602C18.8873 21.0077 19.6128 21.0077 20.0602 20.5602C20.5077 20.1128 20.5077 19.3873 20.0602 18.9398L16.8346 15.7141Z" fill="#475467"/>
                                          </svg>
                                    </label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12 table-responsive" id="table_container">
                                        <table class="table table-borderless text-nowrap dataTable dtr-inline"
                                            id="userTable">
                                            <thead class="border-bottom">
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