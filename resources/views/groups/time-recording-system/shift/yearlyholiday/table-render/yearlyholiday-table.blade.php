<table class="table table-borderless text-nowrap">
    <thead class="border-bottom">
        <tr>
            <th>#</th>
            <th>วันที่</th>
            <th>วันหยุดประจำปี</th>
            <th class="text-end">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($yearlyHolidays as $key => $yearlyHoliday)
        <tr>
            <td>{{$key + 1}}</td>
            <td>{{$yearlyHoliday->holiday_date}}</td>
            <td>{{$yearlyHoliday->name}}</td>
            <td class="text-end">
                @if ($permission->update)
                <a class="btn btn-edit btn-action btn-sm"
                    href="{{ route('groups.time-recording-system.shift.yearlyholiday.view', ['id' => $yearlyHoliday->id]) }}">
                    <i class="fas fa-pencil-alt">
                    </i>
                </a>
                @endif

                @if ($permission->delete == true)
                <a class="btn btn-delete btn-action btn-sm" data-confirm='ลบวันหยุดประจำปี "{{$yearlyHoliday->name}}" หรือไม่?'
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