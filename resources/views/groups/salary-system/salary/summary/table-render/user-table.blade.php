<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th style="width: 8%">รหัสพนักงาน</th>
            <th style="width: 15%">ชื่อ-สกุล</th>
            <th class="text-center" style="width: 13%">เงินเดือน</th>
            <th class="text-center" style="width: 13%">ล่วงเวลา</th>
            <th class="text-center" style="width: 13%">เบี้ยขยัน</th>
            <th class="text-center" style="width: 13%">เงินได้</th>
            <th class="text-center" style="width: 13%">เงินหัก</th>
            <th class="text-center" style="width: 10%">สุทธิ</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        @php
        // $paydayDetailWithToday = $user->getPaydayDetailWithToday();
        $userSummary = $user->userSummary();
        @endphp
        <tr>

            <td>
                {{-- @if (count($user->getErrorDate()) > 0)
                <i class="fas fa-times-circle text-danger"></i>
                @else
                <i class="fas fa-check-circle text-success"></i>
                @endif --}}
                {{ $user->employee_no }}

            </td>
            <td>{{ $user->prefix->name }}{{
                $user->name }} {{
                $user->lastname }}</td>
            <td class="text-center">{{$userSummary['salary']}}</td>
            <td class="text-center">{{$userSummary['overTimeCost']}}</td>
            <td class="text-center">{{$userSummary['deligenceAllowance']}}
            </td>

            <td class="text-left ">

                @foreach ($user->getSummaryIncomeDeductByUsers(1)
                as $getIncomeDeductByUser)
                <li>{{$getIncomeDeductByUser->incomeDeduct->name}}
                    ({{$getIncomeDeductByUser->value}})</li>
                @endforeach
            </td>
            <td class="text-left">
                @foreach ($user->getSummaryIncomeDeductByUsers(2)
                as $getIncomeDeductByUser)
                <li>{{$getIncomeDeductByUser->incomeDeduct->name}}
                    ({{$getIncomeDeductByUser->value}})</li>
                @endforeach
            </td>
            <td class="text-center">xx</td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$users->links()}}