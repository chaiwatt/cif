<div class="table-responsive">
<table class="table table-borderless text-nowrap dataTable dtr-inline">
    <thead class="border-bottom">
        <tr>
            <th>หัวข้อ</th>
            <th>หน่วยงาน</th>
            <th>ปีที่ฝึกอบรม</th>
            <th class="text-end">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($user->trainings->sortBy('year') as $key =>$training)
        <tr>
            <td>{{$training->course}}</td>
            <td>{{$training->organizer}}</td>
            <td>{{$training->year}}</td>
            <td class="text-end">
                <a class="btn btn-edit btn-action btn-sm btn-update-training" data-id="{{$training->id}}">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <a class="btn btn-delete btn-action btn-sm btn-delete-training" data-id="{{$training->id}}">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>