<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
        <tr>
            {{-- <th class="text-center" style="width: 150px">ตรวจสอบเวลา</th> --}}

            <th>รหัสพนักงาน</th>
            <th>ชื่อ-สกุล</th>
            {{-- <th>รอบเงินเดือน</th> --}}
            <th class="text-center">ชม.งาน</th>
            <th class="text-center">มาสาย</th>
            <th class="text-center">กลับก่อน</th>
            <th class="text-center">วันลา</th>
            <th class="text-center">ขาดงาน</th>
            <th class="text-center">ล่วงเวลา</th>
            <th class="text-center">เบี้ยขยัน</th>
            <th class="text-right" style="width: 120px">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        @php
        $paydayDetailWithToday = $user->getPaydayDetailWithToday();
        $userSummary = $user->userSummary();
        @endphp
        <tr>

            <td>
                @if (count($user->getErrorDate()) > 0)
                <i class="fas fa-times-circle text-danger"></i>
                @else
                <i class="fas fa-check-circle text-success"></i>
                @endif
                {{ $user->employee_no }}
                {{-- @php
                $isvalidTimeInOuts =
                $user->IsvalidTimeInOut($paydayDetailWithToday->start_date,$paydayDetailWithToday->end_date)

                @endphp

                @if (count($isvalidTimeInOuts) != 0)
                <i class="fas fa-times-circle text-danger"></i>
                @endif --}}


            </td>
            <td>{{ $user->prefix->name }}{{
                $user->name }} {{
                $user->lastname }}</td>
            {{-- <td>{{$user->getPaydayWithToday()->name}}</td> --}}
            <td class="text-center">{{$userSummary['workHour']}}</td>
            <td class="text-center">{{$userSummary['lateHour']}}</td>
            <td class="text-center">{{$userSummary['earlyHour']}}</td>
            <td class="text-center">{{$userSummary['leaveCountSum']}}</td>
            <td class="text-center">{{$userSummary['absentCountSum']}}</td>
            <td class="text-center">{{$userSummary['overTime']}}</td>
            <td class="text-center">{{$userSummary['deligenceAllowance']}}</td>
            <td class="text-right">

                <a class="btn btn-sm btn-info btn-user" data-id="{{$user->id}}"
                    data-startDate="{{$paydayDetailWithToday->start_date}}"
                    data-endDate="{{$paydayDetailWithToday->end_date}}"
                    href="{{route('groups.salary-system.salary.calculation.information',['start_date' => $paydayDetailWithToday->start_date,'end_date' => $paydayDetailWithToday->end_date,'user_id' => $user->id] )}}"><i
                        class="far fa-list-alt"></i></a>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>
{{$users->links()}}