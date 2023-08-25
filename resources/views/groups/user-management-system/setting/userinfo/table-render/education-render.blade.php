<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th>ระดับ</th>
            <th>สาขาวิชา</th>
            <th>ปีที่จบ</th>
            <th class="text-right">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($user->educations->sortBy('year') as $key =>$education)
        <tr>
            <td>{{$education->level}}</td>
            <td>{{$education->branch}}</td>
            <td>{{$education->year}}</td>
            <td class="text-right">
                <a class="btn btn-info btn-sm btn-update-education" data-id="{{$education->id}}">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <a class="btn btn-danger btn-sm btn-delete-education" data-id="{{$education->id}}">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>