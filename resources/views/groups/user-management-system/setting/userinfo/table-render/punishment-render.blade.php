<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th>ความผิด / โทษ</th>
            <th>วันที่บันทึก</th>
            <th class="text-end">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($user->punishments as $key => $punishment)
        <tr>
            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d',
                $punishment->record_date)->format('d/m/Y') }}</td>
            <td>{{$punishment->punishment}}</td>
            <td class="text-end">
                <a class="btn btn-primary btn-sm btn-update-punishment" data-id="{{$punishment->id}}">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <a class="btn btn-danger btn-sm btn-delete-punishment" data-id="{{$punishment->id}}">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>