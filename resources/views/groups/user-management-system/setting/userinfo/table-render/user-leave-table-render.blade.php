<label for="">วันลาคงเหลือ</label>
<table class="table table-borderless text-nowrap dataTable dtr-inline">
    <thead class="border-bottom">
        <tr>
            <th style="width: 50%">ประเภท</th>
            <th>คงเหลือ</th>
            <th style="width: 150px" class="text-end">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($userLeaves as $key =>$userLeave)
        <tr>
            <td>{{$userLeave->leaveType->name}}</td>
            <td>{{$userLeave->count}}</td>
            <td class="text-end">
                <a class="btn btn-edit btn-action btn-sm btn-update-leave" data-id="{{$userLeave->id}}">
                    <i class="fas fa-pencil-alt"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>