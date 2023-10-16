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
            font-size: 14px
        }

        /* Set A4 size */
        .a4-wrapper {
            width: 210mm;
            height: 297mm;
            margin: 0 auto;
            padding: 20mm;
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
        }

        .box+.box {
            border-top: none;
            margin-top: -1px;
            /* Offset for the removed border */
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
            <h3>ใบจ่ายเงินเดือน</h3>
        </div>

        <div class="box">
            <div class="col12">
                <div class="col4">
                    <div class="title" style="padding: 0px; line-height: 1">
                        <p>ชื่อ-สกุล: {{$user->name}} {{$user->lasrname}}</p>
                        <p>รหัสพนักงาน: {{$user->employee_no}}</p>
                        <p>ตำแหน่ง: {{$user->user_position->name}}</p>
                    </div>
                </div>

                <div class="col4" style="float: right">
                    <div class="title" style="padding: 0px; line-height: 1">
                        <p>แผนก: {{$user->company_department->name}}</p>
                        <p>วันที่จ่าย: {{ \Carbon\Carbon::createFromFormat('Y-m-d',
                            $paydayDetail->payment_date)->format('d/m/Y') }}</p>
                        <p>บัญชี: -</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="box mt-2" style="border-top: none">
            <span style="font-weight:bold">รายรับ</span>
            <div class="col12">
                <div class="col4">

                    <div class="col12">
                        <div style="padding: 0px; line-height: 1">
                            <p>อัตราเงินเดือน: {{number_format($user->salaryRecords->last()->first()->salary, 2)}} บาท
                            </p>
                            <p>เงินเดือน: {{$salarySummary['salary']}} บาท</p>
                            <p>ค่าล่วงเวลา: {{$salarySummary['overTimeCost']}} บาท</p>
                            <p>เบี้ยขยัน: {{$salarySummary['deligenceAllowance']}} บาท</p>
                            <p>เบี้ยขยันประจำวัน: - บาท</p>
                        </div>
                    </div>
                </div>

                <div class="col4" style="float: right">
                    @php
                    $totalIncome = 0;
                    @endphp
                    <div style="padding: 0px; line-height: 1">
                        <p>โบนัสประจำเดือน: -</p>
                        @foreach ($incomes as $income)
                        @php
                        $totalIncome += $income->value;
                        @endphp
                        <p>{{$income->incomeDeduct->name}} {{number_format($income->value, 2)}} บาท</p>
                        @endforeach
                    </div>
                </div>
            </div>
            <span style="font-weight:bold">รายจ่าย</span>
            <div class="col12">
                <div class="col4">
                    @php
                    $totalDeduct = 0;
                    @endphp
                    <div class="col12">
                        <div style="padding: 0px; line-height: 1">
                            <p>ประกันสังคม: {{$salarySummary['socialSecurityFivePercent']}} บาท</p>
                            @foreach ($deducts as $deduct)
                            @php
                            $totalDeduct += $deduct->value;
                            @endphp
                            <p>{{$deduct->incomeDeduct->name}} {{number_format($deduct->value, 2)}} บาท</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="float:right;padding: 0px; line-height: 1;width: 30%;">
            @php
            $netIncome = floatval(str_replace(',', '', $salarySummary['salary'])) + floatval(str_replace(',', '',
            $salarySummary['overTimeCost'])) + floatval(str_replace(',', '', $salarySummary['deligenceAllowance'])) +
            floatval($totalIncome);
            $netDeduct = $totalDeduct + $salarySummary['socialSecurityFivePercent'];
            @endphp
            <p><span class="total-amount">รวมรายได้</span> {{number_format($netIncome, 2)}} บาท</p>
            <p><span class="total-amount">รวมรายจ่าย</span> {{number_format($netDeduct, 2)}} บาท</p>
            <p><span class="total-amount">รวมยอดสุทธิ</span> {{number_format($netIncome - $netDeduct, 2)}} บาท</p>

        </div>

    </div>
</body>

</html>