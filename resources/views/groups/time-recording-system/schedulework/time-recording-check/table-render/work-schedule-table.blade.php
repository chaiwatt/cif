<table class="table table-striped text-nowrap">
    <thead>
        <tr>
            <th>#</th>
            <th>ตารางทำงาน</th>
            <th>เดือน-ปี</th>
            <th>โน้ต</th>
            <th class="text-right">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($workSchedules as $key => $workSchedule)
        <tr>
            <td>{{$key +1}}</td>
            <td>{{$workSchedule->name}}</td>
            <td>{{$workSchedule->monthName($month)}} {{$year}}</td>
            <td>
                @php
                $workScheduleMonthNote =$workSchedule->getWorkScheduleMonthNoteByYearAndMonth($year, $month);
                @endphp
                @if ($workScheduleMonthNote)
                {{ $workScheduleMonthNote->note }}
                @endif
            </td>
            <td class="text-right">
                <a class="btn btn-info btn-sm"
                    href="{{route('groups.time-recording-system.schedulework.time-recording-check.view',['workScheduleId' => $workSchedule->id,'year' => $year,'month' => $month])}}">
                    <i class="fas fa-pencil-alt">
                    </i>
                </a>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>