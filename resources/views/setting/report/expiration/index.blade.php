@extends('layouts.setting-dashboard')
@push('styles')

@endpush
@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">วันหมดอายุวีซ่า / ใบอนุญาต</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">พนักงาน</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>หมดอายุใน</label>
                                <select name="expirationMonth" id="expirationMonth" class="form-control select2"
                                    style="width: 100%;">
                                    <option value="0">หมดอายุแล้ว</option>
                                    <option value="1">1 เดือน</option>
                                    <option value="2">2 เดือน</option>
                                    <option value="3">3 เดือน</option>
                                    <option value="4">4 เดือน</option>
                                    <option value="5">5 เดือน</option>
                                    <option value="6">6 เดือน</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-end">
                            <button class="btn btn-outline-secondary mt-2 d-flex gap-2 align-items-center" id="search_expiration"><i
                                    class="fas fa-search mr-1"></i>ค้นหา</button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">รายชื่อพนักงาน</h3>
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
                                                    <th>รหัสพนักงาน</th>
                                                    <th>ชื่อ-สกุล</th>
                                                    <th>แผนก</th>
                                                    <th>ตำแหน่ง</th>
                                                    <th>วันหมดอายุวีซ่า (วดป.)</th>
                                                    <th>วันหมดอายุใบอนุญาต (วดป.)</th>
                                                </tr>
                                            </thead>
                                            <tbody id="employee_tbody">
                                                @foreach ($users as $key => $user)
                                                <tr>
                                                    <td>{{($key + 1 + $users->perPage() * ($users->currentPage() - 1))}}
                                                    </td>
                                                    <td>{{$user->employee_no}}</td>
                                                    <td>{{$user->prefix->name}}{{$user->name}} {{$user->lastname}}</td>
                                                    <td>{{$user->company_department->name}}</td>
                                                    <td>{{$user->user_position->name}}</td>
                                                    <td
                                                        class="{{ (Carbon\Carbon::parse($user->visa_expiry_date)->lessThan(Carbon\Carbon::now())) ? 'text-danger' : '' }}">
                                                        {{
                                                        Carbon\Carbon::parse($user->visa_expiry_date)->format('d-m-Y')
                                                        }}
                                                    </td>
                                                    <td
                                                        class="{{ (Carbon\Carbon::parse($user->permit_expiry_date)->lessThan(Carbon\Carbon::now())) ? 'text-danger' : '' }}">
                                                        {{
                                                        Carbon\Carbon::parse($user->permit_expiry_date)->format('d-m-Y')
                                                        }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{ $users->links() }}
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

<script type="module" src="{{asset('assets/js/helpers/setting/report/expiration/expiration.js?v=1')}}"></script>

<script>
    $('.select2').select2()
    window.params = {
        searchRoute: '{{ route('setting.report.expiration.search') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>
@endpush
@endsection