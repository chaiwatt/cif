<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th>#</th>
            <th>รหัสพนักงาน</th>
            <th>ชื่อ-สกุล</th>
            <th>แผนก</th>
            <th class="text-right">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody id="approver_tbody">
        @foreach ($users as $key => $user)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$user->employee_no}}</td>
            <td>{{$user->name}} {{$user->lastname}}</td>
            <td>{{$user->company_department->name}}</td>
            <td class="text-right">
                @if ($permission->delete)
                <form
                    action="{{ route('groups.time-recording-system.schedulework.schedule.assignment.user.delete', ['workScheduleId' => $workSchedule->id, 'year' => $year, 'month' => $monthId, 'userId' => $user->id]) }}"
                    method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i></button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>