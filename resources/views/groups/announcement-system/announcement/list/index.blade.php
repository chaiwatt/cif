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
                    <h1 class="m-0">ข่าวประกาศ
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a>
                        </li>
                        <li class="breadcrumb-item active">ข่าวประกาศ</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <a class="btn btn-primary mb-2" href="{{route('groups.announcement-system.announcement.list.create')}}">
                <i class="fas fa-plus mr-1">
                </i>
                เพิ่มข่าวประกาศ
            </a>
            @if ($permission->show)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">รายการข่าวประกาศ</h3>
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
                                                <th class="text-right" style="width: 120px">เพิ่มเติม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($announcements as $announcement)
                                            <tr>
                                                <td>{{$announcement->title}}</td>
                                                <td>{{$announcement->description}}</td>
                                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',
                                                    $announcement->created_at)->format('d/m/Y')
                                                    }}</td>
                                                <td class="text-right">
                                                    <a class="btn btn-sm btn-primary "
                                                        href="{{route('groups.announcement-system.announcement.list.view',['id' => $announcement->id ])}}"><i
                                                            class="fas fa-pencil-alt"></i></a>
                                                    @if ($permission->delete == true)
                                                    <a class="btn btn-danger btn-sm"
                                                        data-confirm='ลบข่าวประกาศ"{{$announcement->name}}" หรือไม่?'
                                                        href="#" data-id="{{$announcement->id}}"
                                                        data-delete-route="{{ route('groups.announcement-system.announcement.list.delete', ['id' => '__id__']) }}"
                                                        data-message="ข่าวประกาศ">
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

<script type="module" src="{{ asset('assets/js/helpers/salary-system/salary/calculation/index.js?v=1') }}">
</script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        searchRoute: '{{ route('groups.salary-system.salary.calculation.search') }}',        
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection