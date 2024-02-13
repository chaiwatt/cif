<div class="table-responsive">
<table class="table table-borderless text-nowrap dataTable dtr-inline">
    <thead class="border-bottom">
        <tr>
            <th>ระดับ</th>
            <th>สาขาวิชา</th>
            <th>ปีที่จบ</th>
            <th class="text-end">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($user->educations->sortBy('year') as $key =>$education)
        <tr>
            <td>{{$education->level}}</td>
            <td>{{$education->branch}}</td>
            <td>{{$education->year}}</td>
            <td class="text-end">
                <a class="btn btn-edit btn-action btn-sm btn-update-education" data-id="{{$education->id}}">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <a class="btn btn-delete btn-action btn-sm btn-delete-education" data-id="{{$education->id}}">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>