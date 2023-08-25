<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th>เอกสาร</th>
            <th class="text-right">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($user->user_attachments as $key =>$user_attachment)
        <tr>
            <td>{{$user_attachment->name}}</td>
            <td class="text-right">
                <a class="btn btn-primary btn-sm"
                    href="{{url('/storage/uploads/attachment')}}/{{$user_attachment->file}}">
                    <i class="fas fa-download"></i>
                </a>
                <a class="btn btn-danger btn-sm btn-delete-user-attachment" data-id="{{$user_attachment->id}}">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>