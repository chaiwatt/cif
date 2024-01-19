<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th style="width: 8%">รหัสพนักงาน</th>
            <th style="width: 14%">ชื่อ-สกุล</th>
            <th style="width: 12%">แผนก</th>
            <th class="text-center" style="width: 8%">เงินเดือน</th>
            <th class="text-center" style="width: 8%">ล่วงเวลา</th>
            <th class="text-center" style="width: 8%">เบี้ยขยัน</th>
            <th class="text-center" style="width: 13%">เงินได้อื่นๆ</th>
            <th class="text-center" style="width: 13%">เงินหักอื่นๆ</th>
            <th class="text-center" style="width: 8%">ปกสค.</th>
            <th class="text-center" style="width: 10%">สุทธิ</th>
            <th class="text-end">ดาวน์โหลด</th>
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
            <td>{{$user->company_department->name}}</td>
            <td class="text-center">{{$userSummary['salary']}}</td>
            <td class="text-center">{{$userSummary['overTimeCost']}}</td>
            <td class="text-center">{{$userSummary['deligenceAllowance']}}
            </td>

            <td class="text-start">
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
            <td class="text-start">
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
            <td class="text-end">
                <a href="{{route('groups.salary-system.salary.calculation-list.summary.download-single',['user_id' => $user->id,'payday_detail_id' => $paydayDetail->id])}}"
                    class="btn btn-sm btn-primary"><i class="fas fa-download"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$users->links()}}