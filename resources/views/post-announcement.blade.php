@extends('layouts.landing')
@section('content')
<div class="row">

    <!-- /.col-md-6 -->
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title m-0"><i class="fas fa-bullhorn mr-2 text-gray"></i>{{$announcement->title}}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        {!!$announcement->body!!}
                    </div>
                    @if (count($announcementAttachments) != 0)

                    <div class="col-12 mt-2">
                        <table class="table table-bordered table-striped dataTable dtr-inline">
                            <thead>
                                <tr>
                                    <th>ไฟลน์แนบ</th>
                                    <th class="text-right" style="width: 150px">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($announcementAttachments as $announcementAttachment)
                                <tr>
                                    <td>{{$announcementAttachment->name}}</td>
                                    <td class="text-right">
                                        <a class="btn btn-primary btn-sm"
                                            href="{{url('/storage/uploads/attachment') .'/'. $announcementAttachment->file}}">
                                            <i class="fas fa-download"></i>
                                        </a>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @endif
                </div>


            </div>
        </div>
    </div>
    <!-- /.col-md-6 -->
</div>
@endsection