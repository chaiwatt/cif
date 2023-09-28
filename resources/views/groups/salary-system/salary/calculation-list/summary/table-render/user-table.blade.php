<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th style="width: 8%">รหัสพนักงาน</th>
            <th style="width: 15%">ชื่อ-สกุล</th>
            <th class="text-center" style="width: 10%">เงินเดือน</th>
            <th class="text-center" style="width: 10%">ล่วงเวลา</th>
            <th class="text-center" style="width: 10%">เบี้ยขยัน</th>
            <th class="text-center" style="width: 15%">เงินได้อื่นๆ</th>
            <th class="text-center" style="width: 15%">เงินหักอื่นๆ</th>
            <th class="text-center" style="width: 10%">เงินปกสค.</th>
            <th class="text-center" style="width: 10%">สุทธิ</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($users as $user)
        @php
        $userSummary = $user->salarySummary($paydayDetail->id);
        $netIncome = round(str_replace(',', '', $userSummary['salary'])) +
        round(str_replace(',', '', $userSummary['overTimeCost'])) +
        round(str_replace(',', '', $userSummary['deligenceAllowance']));
        @endphp
        <tr>

            <td>
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
                @php
                $totalIncome = 0;
                @endphp
                @foreach ($user->getSummaryIncomeDeductByUsers(1,$paydayDetail->id)
                as $getIncomeDeductByUser)
                @php
                $totalIncome += $getIncomeDeductByUser->value;
                @endphp
                <li>{{$getIncomeDeductByUser->incomeDeduct->name}}
                    ({{$getIncomeDeductByUser->value}})</li>
                @endforeach
            </td>
            <td class="text-left">
                @php
                $totalDeduct = 0;
                @endphp
                @foreach ($user->getSummaryIncomeDeductByUsers(2,$paydayDetail->id)
                as $getIncomeDeductByUser)
                @php
                $totalDeduct += $getIncomeDeductByUser->value;
                @endphp
                <li>{{$getIncomeDeductByUser->incomeDeduct->name}}
                    ({{$getIncomeDeductByUser->value}})</li>
                @endforeach
            </td>
            <td class="text-center">{{$userSummary['socialSecurityFivePercent']}}
            </td>
            @php
            $netIncome = $netIncome + $totalIncome - $totalDeduct -
            round(str_replace(',', '',
            $userSummary['socialSecurityFivePercent']));
            @endphp
            <td class="text-center">{{number_format($netIncome, 2)}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$users->links()}}