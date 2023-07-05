<table class="table table-striped text-nowrap">
    <thead>
        <tr>
            <th>ชื่อกะการทำงาน</th>
            <th>เวลาเริ่มงาน</th>
            <th>เวลาเลิกงาน</th>
            <th>ปีกะทำงาน</th>
            <th class="text-right">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($shifts->where('base_shift',1) as $shift)
        <tr>
            <td>{{$shift->name}}</td>
            <td>{{$shift->start}}</td>
            <td>{{$shift->end}}</td>
            <td>{{$shift->year}}</td>
            <td class="text-right">
                @if ($permission->update)
                <a class="btn btn-info btn-sm"
                    href="{{ route('groups.time-recording-system.shift.timeattendance.view', ['id' => $shift->id]) }}">
                    <i class="fas fa-pencil-alt">
                    </i>
                </a>
                @endif
                @if ($permission->create)
                <a class="btn btn-success btn-sm"
                    href="{{ route('groups.time-recording-system.shift.timeattendance.duplicate', ['id' => $shift->id]) }}">
                    <i class="fas fa-copy"></i>
                    </i>
                </a>
                @endif

                @if ($permission->delete == true)
                <a class="btn btn-danger btn-sm" data-confirm='ลบกะการทำงาน "{{$shift->name}}" หรือไม่?' href="#"
                    data-id="{{$shift->id}}"
                    data-delete-route="{{ route('groups.time-recording-system.shift.timeattendance.delete', ['id' => '__id__']) }}"
                    data-message="กะการทำงาน">
                    <i class="fas fa-trash"></i>
                </a>
                @endif
            </td>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>