<div class="table-responsive">
    <table class="table table-borderless text-nowrap dataTable dtr-inline">
        <thead class="border-bottom">
            <tr>
                <th>เอกสาร</th>
                <th class="text-end">เพิ่มเติม</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user->user_attachments as $key =>$user_attachment)
            <tr>
                <td>{{$user_attachment->name}}</td>
                {{-- <td>{{$user_attachment->file}}</td> --}}
                <td class="text-end">
                    @php
                    $path = $user_attachment->file;
                    if ($user_attachment->type == 1){
                    $path = url('/storage/uploads/attachment') .'/'.
                    $user_attachment->file;
                    }
                    @endphp
                    <a class="btn btn-user btn-action btn-sm" href="{{$path}}">
                        <i class="fas fa-download"></i>
                    </a>
                    <a class="btn btn-delete btn-action btn-sm btn-delete-user-attachment" data-id="{{$user_attachment->id}}">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>