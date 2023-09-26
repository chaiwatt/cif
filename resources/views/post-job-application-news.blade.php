@extends('layouts.landing')
@section('content')
<div class="row">

    <!-- /.col-md-6 -->
    <div class="col-lg-12">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h5 class="card-title m-0"><i class="fas fa-user-tie mr-2 text-gray"></i>{{$applicationNew->title}}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        {!!$applicationNew->body!!}
                    </div>
                    @if (count($applicationNewAttachments) != 0)

                    <div class="col-12 mt-2">
                        <table class="table table-bordered table-striped dataTable dtr-inline">
                            <thead>
                                <tr>
                                    <th>ไฟลน์แนบ</th>
                                    <th class="text-right" style="width: 150px">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($applicationNewAttachments as $applicationNewAttachment)
                                <tr>
                                    <td>{{$applicationNewAttachment->name}}</td>
                                    <td class="text-right">
                                        <a class="btn btn-primary btn-sm"
                                            href="{{url('/storage/uploads/attachment') .'/'. $applicationNewAttachment->file}}">
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