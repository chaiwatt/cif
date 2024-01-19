<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th>รหัสพนักงาน</th>
            <th>ชื่อ-สกุล</th>
            <th class="text-center">ชม.งาน</th>
            <th class="text-center">มาสาย(ชม.)</th>
            <th class="text-center">กลับก่อน(ชม.)</th>
            <th class="text-center">วันลา</th>
            <th class="text-center">ขาดงาน</th>
            <th class="text-center">OT(ชม.)</th>
            <th class="text-end" style="width: 120px">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        @php
        $userSummary = $user->salarySummary($paydayDetail->id);
        @endphp
        <tr>
            <td>
                @if (count($user->getMissingDate($paydayDetail->id)) > 0)
                <i class="fas fa-times-circle text-danger"></i>
                @else
                <i class="fas fa-check-circle text-success"></i>
                @endif
                {{ $user->employee_no }}

            </td>
            <td>{{ $user->prefix->name }}{{
                $user->name }} {{
                $user->lastname }}</td>
            <td class="text-center">{{$userSummary['workHour']}}</td>
            <td class="text-center">{{$userSummary['lateHour']}}</td>
            <td class="text-center">{{$userSummary['earlyHour']}}</td>
            <td class="text-center">{{$userSummary['leaveCountSum']}}</td>
            <td class="text-center">{{$userSummary['absentCountSum']}}</td>
            <td class="text-center">{{$userSummary['overTime']}}</td>
            </td>
            <td class="text-end">
                <a class="btn btn-sm btn-primary btn-user" data-id="{{$user->id}}"
                    data-startDate="{{$paydayDetail->start_date}}" data-endDate="{{$paydayDetail->end_date}}"
                    href="{{route('groups.salary-system.salary.calculation-extra-list.calculation.information',['start_date' => $paydayDetail->start_date,'end_date' => $paydayDetail->end_date,'user_id' => $user->id,'payday_detail_id' => $paydayDetail->id] )}}"><i
                        class="far fa-list-alt"></i></a>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>
{{$users->links()}}