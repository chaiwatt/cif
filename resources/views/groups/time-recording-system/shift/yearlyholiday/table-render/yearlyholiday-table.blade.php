<table class="table table-striped text-nowrap">
    <thead>
        <tr>
            <th>#</th>
            <th>วันที่</th>
            <th>วันหยุดประจำปี</th>
            <th class="text-right">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($yearlyHolidays as $key => $yearlyHoliday)
        <tr>
            <td>{{$key + 1}}</td>
            <td>{{$yearlyHoliday->holiday_date}}</td>
            <td>{{$yearlyHoliday->name}}</td>
            <td class="text-right">
                @if ($permission->update)
                <a class="btn btn-info btn-sm"
                    href="{{ route('groups.time-recording-system.shift.yearlyholiday.view', ['id' => $yearlyHoliday->id]) }}">
                    <i class="fas fa-pencil-alt">
                    </i>
                </a>
                @endif

                @if ($permission->delete == true)
                <a class="btn btn-danger btn-sm" data-confirm='ลบวันหยุดประจำปี "{{$yearlyHoliday->name}}" หรือไม่?'
                    href="#" data-id="{{$yearlyHoliday->id}}"
                    data-delete-route="{{ route('groups.time-recording-system.shift.yearlyholiday.delete', ['id' => '__id__']) }}"
                    data-message="วันหยุดประจำปี">
                    <i class="fas fa-trash"></i>
                </a>
                @endif
            </td>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>