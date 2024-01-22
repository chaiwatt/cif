<table class="table table-borderless text-nowrap dataTable dtr-inline">
    <thead class="border-bottom">
        <tr>
            <th>#</th>
            <th>รหัสพนักงาน</th>
            <th>ชื่อ-สกุล</th>
            <th>แผนก</th>
            <th class="text-end">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $key => $user)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$user->employee_no}}</td>
            <td>{{$user->name}} {{$user->lastname}}</td>
            <td>{{$user->company_department->name}}</td>
            <td class="text-end">
                @if ($permission->delete)
                <form
                    action="{{ route('groups.time-recording-system.schedulework.schedule.assignment.user.delete', ['workScheduleId' => $workSchedule->id, 'year' => $year, 'month' => $monthId, 'userId' => $user->id]) }}"
                    method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-delete btn-action btn-sm" type="submit"><i class="fas fa-trash"></i></button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>