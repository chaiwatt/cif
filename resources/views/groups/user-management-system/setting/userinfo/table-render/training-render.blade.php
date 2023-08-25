<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th>หัวข้อ</th>
            <th>หน่วยงาน</th>
            <th>ปีที่ฝึกอบรม</th>
            <th class="text-right">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($user->trainings->sortBy('year') as $key =>$training)
        <tr>
            <td>{{$training->course}}</td>
            <td>{{$training->organizer}}</td>
            <td>{{$training->year}}</td>
            <td class="text-right">
                <a class="btn btn-info btn-sm btn-update-training" data-id="{{$training->id}}">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <a class="btn btn-danger btn-sm btn-delete-training" data-id="{{$training->id}}">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>