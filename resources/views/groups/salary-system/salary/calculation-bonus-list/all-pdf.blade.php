<!DOCTYPE html>
<html>

<head>
    <title>รายงานโบนัสประจำปี</title>

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
            width: 9%;
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
            <h3>รายงานโบนัสประจำปี {{ \Carbon\Carbon::createFromFormat('Y-m-d',
                $bonus->issued)->format('d/m/Y') }}</h3>
        </div>
        <div class="box" style="border-left:none;border-right:none">
            <div class="col12">
                <div class="col1">รหัส</div>
                <div class="col1">ชื่อพนักงาน</div>
                <div class="col1" style="text-align: center">เงินเดือน</div>
                <div class="col1" style="text-align: center">ค่าล่วงเวลา</div>
                <div class="col1" style="text-align: center">เบี้ยขยันประจำวัน</div>
                <div class="col1" style="text-align: center">เบี้ยขยัน</div>
                <div class="col1" style="text-align: center">ประกันสังคม</div>
                <div class="col1" style="text-align: center">รายได้อื่นๆ</div>
                <div class="col1" style="text-align: center">หักภาษี</div>
                <div class="col1" style="text-align: center">หักอื่นๆ</div>
                <div class="col1" style="text-align: right;float:rigth">สุทธิ</div>
            </div>
        </div>

        @foreach ($companyDepartments as $key => $companyDepartment)
        <div class="box" style="border:none">
            <span style="font-weight: bold">{{$companyDepartment->name}}
                {{count($users->where('company_department_id',$companyDepartment->id))}} คน</span>
            @php
            $totalBonusCost = 0;
            $totalBonusCostTax = 0;

            @endphp
            @foreach ($users->where('company_department_id',$companyDepartment->id) as $user)
            @php
            $bonusObect = $user->getBonus($bonus->id);

            $bonusCost = $bonusObect->cost;
            $bonusCostTax = $bonusCost * $taxSetting->bonus_tax_percent * 0.01;


            $totalBonusCost += $bonusCost;
            $totalBonusCostTax += $bonusCostTax;

            @endphp

            <div class="col12">
                <div class="col1">{{$user->employee_no}}</div>
                <div class="col1">{{$user->name}} {{$user->lastname}}</div>
                <div class="col1" style="text-align: center">-</div>
                <div class="col1" style="text-align: center">-</div>
                <div class="col1" style="text-align: center">-</div>
                <div class="col1" style="text-align: center">-</div>
                <div class="col1" style="text-align: center">-</div>
                <div class="col1" style="text-align: center">{{number_format($bonusCost, 2)}}</div>
                <div class="col1" style="text-align: center">{{number_format($bonusCostTax, 2)}}</div>
                <div class="col1" style="text-align: center">-</div>
                <div class="col1" style="text-align: center;text-align: right;float:rigth">
                    {{number_format($bonusCost-$bonusCostTax,
                    2)}}</div>

            </div>
            @endforeach
            <div class="col12">
                <div class="col1" style="width: 18%;text-align: center;font-weight:bold">รวม</div>
                <div class="col1" style="text-align: center">-</div>
                <div class="col1" style="text-align: center">-</div>
                <div class="col1" style="text-align: center">-</div>
                <div class="col1" style="text-align: center">-</div>
                <div class="col1" style="text-align: center">-</div>
                <div class="col1" style="text-align: center;font-weight:bold">{{number_format($totalBonusCost, 2)}}
                </div>
                <div class="col1" style="text-align: center;font-weight:bold">{{number_format($totalBonusCostTax, 2)}}
                </div>
                <div class="col1" style="text-align: center">-</div>
                <div class="col1" style="text-align: center;font-weight:bold;text-align: right;float:rigth">
                    {{number_format($totalBonusCost-$totalBonusCostTax, 2)}}
                </div>
            </div>
        </div>
        @endforeach


    </div>
</body>

</html>