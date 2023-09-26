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
            {{-- <td>{{$user_attachment->file}}</td> --}}
            <td class="text-right">
                @php
                $path = $user_attachment->file;
                if ($user_attachment->type == 1){
                $path = url('/storage/uploads/attachment') .'/'.
                $user_attachment->file;
                }
                @endphp
                <a class="btn btn-primary btn-sm" href="{{$path}}">
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