<table class="table table-borderless text-nowrap">
    <thead class="border-bottom">
        <tr>
            {{-- <th>#</th> --}}
            <th>ชื่อกะการทำงาน</th>
            <th>เวลาเริ่มงาน</th>
            <th>เวลาเลิกงาน</th>
            <th>ปีกะทำงาน</th>
            <th class="text-end">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($shifts->where('base_shift',1) as $key => $shift)
        <tr>
            {{-- <td>{{$key +1}}</td> --}}
            <td>{{$shift->name}}</td>
            <td>{{$shift->start}}</td>
            <td>{{$shift->end}}</td>
            <td>{{$shift->year}}</td>
            <td class="text-end">
                @if ($permission->update)
                <a class="btn btn-edit btn-action btn-sm"
                    href="{{ route('groups.time-recording-system.shift.timeattendance.view', ['id' => $shift->id]) }}">
                    <i class="fas fa-pencil-alt">
                    </i>
                </a>
                @endif
                @if ($permission->create)
                <a class="btn btn-user btn-action btn-sm"
                    href="{{ route('groups.time-recording-system.shift.timeattendance.duplicate', ['id' => $shift->id]) }}">
                    <i class="fas fa-copy"></i>
                    </i>
                </a>
                @endif

                @if ($permission->delete == true)
                <a class="btn btn-delete btn-action btn-sm" data-confirm='ลบกะการทำงาน "{{$shift->name}}" หรือไม่?' href="#"
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