<div class="col-12">{!!$topic->body!!}</div>
@if (count($topicAttachments) != 0)

<div class="col-12 mt-2">
    <table class="table table-bordered table-striped dataTable dtr-inline">
        <thead>
            <tr>
                <th>ไฟลน์แนบ</th>
                <th class="text-right" style="width: 200px">เพิ่มเติม</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($topicAttachments as $topicAttachment)
            <tr>
                <td>{{$topicAttachment->name}}</td>
                <td class="text-right">
                    <a class="btn btn-primary btn-sm"
                        href="{{url('/storage/uploads/attachment') .'/'. $topicAttachment->file}}">
                        <i class="fas fa-download"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endif