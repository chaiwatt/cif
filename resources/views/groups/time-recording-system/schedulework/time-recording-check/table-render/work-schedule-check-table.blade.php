<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th class="text-center" style="width: 150px">ตรวจสอบ</th>
            <th style="width: 200px">วันที่ผิดพลาด</th>
            <th style="width: 200px">รหัสพนักงาน</th>
            <th>ชื่อ-สกุล</th>
            <th>แผนก</th>
            <th class="text-right" style="width: 120px">แก้ไข</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($usersWithWorkScheduleAssignments as $userWithWorkSchedule)
        <tr>
            <td class="text-center">
                <!-- You can access the date_in_list of each user using the $userWithWorkSchedule variable -->
                @if (count($userWithWorkSchedule['date_in_list']) > 0)
                <i class="fas fa-times-circle text-danger"></i>
                @else
                <i class="fas fa-check-circle text-success"></i>
                @endif
            </td>
            <td>
                @if (count($userWithWorkSchedule['date_in_list']) > 0)
                <ul>
                    @foreach ($userWithWorkSchedule['date_in_list'] as $dateIn)
                    <li>{{ \Carbon\Carbon::parse($dateIn)->format('d/m/Y') }}</li>
                    @endforeach
                </ul>
                @endif
            </td>
            <td>{{ $userWithWorkSchedule['user']->employee_no }}</td>
            <td>{{ $userWithWorkSchedule['user']->prefix->name }}{{ $userWithWorkSchedule['user']->name }} {{
                $userWithWorkSchedule['user']->lastname }}</td>
            <td>{{ $userWithWorkSchedule['user']->company_department->name }}</td>
            <td class="text-right"><a class="btn btn-sm btn-info" data-id="{{$userWithWorkSchedule['user']->id}}"
                    id="user"><i class="fas fa-pencil-alt"></i></a></td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $usersWithWorkScheduleAssignments->links() }}