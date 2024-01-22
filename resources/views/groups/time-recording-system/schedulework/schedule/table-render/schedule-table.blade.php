<table class="table table-borderless text-nowrap">
    <thead class="border-bottom">
        <tr>
            <th>#</th>
            <th>ชื่อตารางทำงาน</th>
            <th>ปีตารางทำงาน</th>
            <th>คำอธิบาย</th>
            <th class="text-end">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($workSchedules as $key=> $workSchedule)
        <tr>
            <td>{{$key + 1}}</td>
            <td>{{$workSchedule->name}}</td>
            <td>{{$workSchedule->year}}</td>
            <td>{{$workSchedule->description}}</td>
            <td class="text-end">
                @if ($permission->update)
                <a class="btn btn-action btn-edit btn-sm"
                    href="{{route('groups.time-recording-system.schedulework.schedule.view',['id' => $workSchedule->id])}}">
                    <i class="fas fa-pencil-alt">
                    </i>
                </a>
                @endif
                @if ($permission->create)
                <a class="btn btn-action btn-links btn-sm"
                    href="{{ route('groups.time-recording-system.schedulework.schedule.assignment', ['id' => $workSchedule->id]) }}">
                    <i class="fas fa-link"></i>
                    </i>
                </a>
                @endif
                @if ($permission->delete == true)
                <a class="btn btn-action btn-delete btn-sm" data-confirm='ลบตารางทำงาน "{{$workSchedule->name}}" หรือไม่?' href="#"
                    data-id="{{$workSchedule->id}}"
                    data-delete-route="{{ route('groups.time-recording-system.schedulework.schedule.delete', ['id' => '__id__']) }}"
                    data-message="ตารางทำงาน">
                    <i class="fas fa-trash"></i>
                </a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>