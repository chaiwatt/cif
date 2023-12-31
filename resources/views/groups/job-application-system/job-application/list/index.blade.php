@extends('layouts.dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/loading.css?v=1.0') }}">
@endpush
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    @include('layouts.partial.loading')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">ข่าวสมัครงาน
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a>
                        </li>
                        <li class="breadcrumb-item active">ข่าวสมัครงาน</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <a class="btn btn-primary mb-2"
                href="{{route('groups.job-application-system.job-application.list.create')}}">
                <i class="fas fa-plus mr-1">
                </i>
                เพิ่มข่าวสมัครงาน
            </a>
            @if ($permission->show)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">รายการข่าวสมัครงาน</h3>
                            {{-- @if (count($users) !=0)
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="search_query" id="search_query"
                                        class="form-control float-right" placeholder="ค้นหา">
                                </div>
                            </div>
                            @endif --}}

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12" id="table_container">
                                    <table class="table table-bordered table-striped dataTable dtr-inline">
                                        <thead>
                                            <tr>
                                                <th>ข่าวประกาศ</th>
                                                <th>คำอธิบาย</th>
                                                <th>วันที่เพิ่ม</th>
                                                <th>สถานะ</th>
                                                <th class="text-right" style="width: 120px">เพิ่มเติม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($applicationNews as $applicationNew)
                                            <tr>
                                                <td>{{$applicationNew->title}}</td>
                                                <td>{{$applicationNew->description}}</td>
                                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',
                                                    $applicationNew->created_at)->format('d/m/Y')
                                                    }}</td>
                                                <td>
                                                    @if ($applicationNew->status == 1)
                                                    แสดง
                                                    @elseif($applicationNew->status == 2)
                                                    ไม่แสดง
                                                    @endif
                                                </td>
                                                <td class="text-right">
                                                    <a class="btn btn-sm btn-primary "
                                                        href="{{route('groups.job-application-system.job-application.list.view',['id' => $applicationNew->id ])}}"><i
                                                            class="fas fa-pencil-alt"></i></a>
                                                    @if ($permission->delete == true)
                                                    <a class="btn btn-danger btn-sm"
                                                        data-confirm='ลบข่าวสมัครงาน"{{$applicationNew->name}}" หรือไม่?'
                                                        href="#" data-id="{{$applicationNew->id}}"
                                                        data-delete-route="{{ route('groups.job-application-system.job-application.list.delete', ['id' => '__id__']) }}"
                                                        data-message="ข่าวสมัครงาน">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    @endif
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

            @endif

        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    {{-- <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button> --}}
    <button type="button" class="btn btn-primary" id="bntUpdateReportField">ต่อไป</button>
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