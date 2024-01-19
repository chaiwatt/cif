<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th>วันที่ปรับ</th>
            <th>เงินเดือน</th>
            <th class="text-primary">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($user->salaryRecords->sortBy('record_date') as $key =>
        $salaryRecord)
        <tr>
            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d',
                $salaryRecord->record_date)->format('d/m/Y') }}</td>
            <td>{{$salaryRecord->salary}}</td>
            <td class="text-primary">
                <a class="btn btn-primary btn-sm btn-update-salary" data-id="{{$salaryRecord->id}}">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <a class="btn btn-danger btn-sm btn-delete-salary" data-id="{{$salaryRecord->id}}">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>