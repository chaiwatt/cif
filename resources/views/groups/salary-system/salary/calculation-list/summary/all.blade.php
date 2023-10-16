<!DOCTYPE html>
<html>

<head>
    <title>รายงานค่าทักษะ</title>

    <style>
        /* HAMONY DIRECTION */
        /* Reset default padding and margin for all elements */
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Kanit" !important;
            font-size: 12px
        }

        /* Set A4 size */
        .a4-wrapper {
            height: 210mm;
            width: 297mm;
            margin: 0 auto;
            padding: 7mm;
            /* Remove border */
            border: none;
            /* Add box-shadow for visual separation */
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);

        }

        .total-label {
            font-weight: bold;
            text-align: right;
        }

        .total-amount {
            font-weight: bold;
        }

        tfoot td {
            border-top: 1px solid #000;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2,
        .header h3,
        .header h3 {
            margin: 0;
        }

        .col6 {
            width: 50%;
            float: left;
        }

        .col4 {
            width: 33%;
            min-width: 100px;
            float: left;
        }

        .col1 {
            width: 11.1%;
            float: left;
        }

        .col12 {
            width: 100%;
            /* float: left; */
        }

        .mt-2 {
            margin-bottom: 20px;
        }

        .container {
            width: 100%;
        }

        .box {
            width: 100%;
            border: 1px solid #000;
            padding-left: 10;
            /* page-break-inside: avoid; */
        }

        .box+.box {
            border-top: none;
            margin-top: -1px;

        }

        /* Additional styles for page break when printing */
        /* @media print {
            .a4-wrapper {
                page-break-after: always;
            }
        } */
    </style>
</head>

<body>

    <div class="a4-wrapper">
        <div class="header">
            <h3>บริษัทฉวีวรรณ อินเตอร์เนชั่นแนล ฟู้ดส์ จำกัด</h3>
            <h3>รายงานจ่ายเงินเดือน {{ \Carbon\Carbon::createFromFormat('Y-m-d',
                $paydayDetail->payment_date)->format('d/m/Y') }}</h3>
        </div>
        <div class="box" style="border-left:none;border-right:none">
            <div class="col12">
                <div class="col1">รหัส</div>
                <div class="col1">ชื่อพนักงาน</div>
                {{-- <div class="col1" style="text-align: center">วันทำงาน</div> --}}
                <div class="col1" style="text-align: center">เงินเดือน</div>
                <div class="col1" style="text-align: center">ค่าล่วงเวลา</div>
                <div class="col1" style="text-align: center">เบี้ยขยัน</div>
                <div class="col1" style="text-align: center">ประกันสังคม</div>
                <div class="col1" style="text-align: center">รายได้อื่นๆ</div>
                <div class="col1" style="text-align: center">หักอื่นๆ</div>
                <div class="col1" style="text-align: right;float:rigth">สุทธิ</div>
            </div>
        </div>

        @foreach ($companyDepartments as $key => $companyDepartment)
        <div class="box" style="border:none">
            <span style="font-weight: bold">{{$companyDepartment->name}}
                {{count($users->where('company_department_id',$companyDepartment->id))}} คน</span>
            @php
            $totalSummary = 0;
            $totalSalary = 0;
            $totalNetIncome = 0;
            $totalnetDeduct = 0;
            $totaloverTimeCost= 0;
            $totaldeligenceAllowance = 0;
            $totalsocialSecurityFivePercent = 0;
            @endphp
            @foreach ($users->where('company_department_id',$companyDepartment->id) as $user)
            @php
            $netDeduct = 0;
            $netIncome = 0;

            $userSummary = $user->salarySummary($paydayDetail->id);
            $netSalary = round(str_replace(',', '', $userSummary['salary'])) +
            round(str_replace(',', '', $userSummary['overTimeCost'])) +
            round(str_replace(',', '', $userSummary['deligenceAllowance']));

            foreach ($user->getSummaryIncomeDeductByUsers(2,$paydayDetail->id) as $getIncomeDeductByUser) {
            $netDeduct += $getIncomeDeductByUser->value;
            }

            foreach ($user->getSummaryIncomeDeductByUsers(1,$paydayDetail->id) as $getIncomeDeductByUser) {
            $netIncome += $getIncomeDeductByUser->value;
            }

            $summary = $netSalary + $netIncome - $netDeduct -
            round(str_replace(',', '',
            $userSummary['socialSecurityFivePercent']));

            $totalSalary += round(str_replace(',', '',$userSummary['salary']));
            $totaloverTimeCost += round(str_replace(',', '',$userSummary['overTimeCost']));
            $totaldeligenceAllowance += round(str_replace(',', '',$userSummary['deligenceAllowance']));
            $totalsocialSecurityFivePercent += round(str_replace(',', '',$userSummary['socialSecurityFivePercent']));
            $totalNetIncome += $netIncome;
            $totalnetDeduct += $netDeduct;
            $totalSummary += $summary;
            @endphp

            <div class="col12">
                <div class="col1">{{$user->employee_no}}</div>
                <div class="col1">{{$user->name}} {{$user->lastname}}</div>
                <div class="col1" style="text-align: center">{{$userSummary['salary']}}</div>
                <div class="col1" style="text-align: center">{{$userSummary['overTimeCost']}}</div>
                <div class="col1" style="text-align: center">{{$userSummary['deligenceAllowance']}}</div>
                <div class="col1" style="text-align: center">{{$userSummary['socialSecurityFivePercent']}}</div>
                <div class="col1" style="text-align: center">{{ $netIncome != 0 ? number_format($netIncome, 2) : '-' }}
                </div>
                <div class="col1" style="text-align: center">{{ $netDeduct != 0 ? number_format($netDeduct, 2) : '-' }}
                </div>
                <div class="col1" style="text-align: right;float:rigth">{{number_format($summary, 2)}}</div>
            </div>
            @endforeach
            <div class="col12">
                <div class="col1" style="width: 22.2%;text-align: center;font-weight:bold">รวม</div>
                <div class="col1" style="text-align: center;font-weight:bold">{{number_format($totalSalary, 2)}}</div>
                <div class="col1" style="text-align: center;font-weight:bold">{{number_format($totaloverTimeCost, 2)}}
                </div>
                <div class="col1" style="text-align: center;font-weight:bold">{{number_format($totaldeligenceAllowance,
                    2)}}</div>
                <div class="col1" style="text-align: center;font-weight:bold">
                    {{number_format($totalsocialSecurityFivePercent, 2)}}</div>
                <div class="col1" style="text-align: center;font-weight:bold">{{number_format($totalNetIncome, 2)}}
                </div>
                <div class="col1" style="text-align: center;font-weight:bold">{{number_format($totalnetDeduct, 2)}}
                </div>
                <div class="col1" style="text-align: right;float:rigth;font-weight:bold">{{number_format($totalSummary,
                    2)}}</div>
            </div>
        </div>
        @endforeach


    </div>
</body>

</html>