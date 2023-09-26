@extends('layouts.landing')
@section('content')
<div class="row">
    <div class="col-lg-12">
        @if (count($announcements->where('status',1)) != 0)
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title m-0"><i class="fas fa-bullhorn mr-2 text-gray"></i>ข่าวประกาศ</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped dataTable dtr-inline" id="userTable">
                    <thead>
                        <tr>
                            <th style="width: 20%">วันที่</th>
                            <th>ข่าวประกาศ</th>
                            <th style="width: 15%" class="text-right">เพิ่มเติม</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($announcements->where('status',1) as $announcement)
                        <tr>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',
                                $announcement->created_at)->format('d/m/Y')
                                }}</td>
                            <td>{{$announcement->title}}</td>
                            <td class="text-right"><a href="{{route('post-announcement',['id' => $announcement->id])}}"
                                    class="btn btn-sm btn-info">อ่าน</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        @endif
    </div>
    <div class="col-lg-12">
        @if (count($applicationNews->where('status',1)) != 0)
        <div class="card card-success card-outline">
            <div class="card-header">
                <h5 class="card-title m-0"><i class="fas fa-user-tie mr-2 text-gray"></i>ข่าวรับสมัครงาน</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped dataTable dtr-inline" id="userTable">
                    <thead>
                        <tr>
                            <th style="width: 20%">วันที่</th>
                            <th>ข่าวรับสมัครงาน</th>
                            <th style="width: 15%" class="text-right">เพิ่มเติม</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applicationNews->where('status',1) as $applicationNew)
                        <tr>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',
                                $applicationNew->created_at)->format('d/m/Y')
                                }}</td>
                            <td>{{$applicationNew->title}}</td>
                            <td class="text-right"><a
                                    href="{{route('post-job-application-news',['id' => $applicationNew->id])}}"
                                    class="btn btn-sm btn-info">อ่าน</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        @endif
    </div>
    <!-- /.col-md-6 -->
</div>
@endsection