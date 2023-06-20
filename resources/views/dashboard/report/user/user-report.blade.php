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

        table {
            width: 100%;
            border-collapse: collapse;
            /* Remove border */
            border: none;
            margin-bottom: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            width: calc(100% / 10);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
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

        .title {
            text-align: center;
            margin-bottom: 20px;
        }

        .title h2,
        .title h3,
        .title h3 {
            margin: 0;
        }

        /* Additional styles for page break when printing */
        @media print {
            .a4-wrapper {
                page-break-after: always;
            }
        }
    </style>
</head>

<body>
    <div class="a4-wrapper">
        <div class="title">
            <h3>บริษัทฉวีวรรณ อินเตอร์เนชั่นแนล ฟู้ดส์ จำกัด</h3>
            <h3>ตารางบันทึกค่าทักษะพนักงาน</h3>
            <h3>ประจำวันที่ 16 - 30 เมษายน 2566</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2">รหัส</th>
                    <th rowspan="2">ชื่อ-สกุล</th>
                    <th rowspan="2">แผนก</th>
                    <th rowspan="2">ตกหล่น</th>
                    <th colspan="4">ค่าทักษะ</th>
                    <th>รวม</th>
                </tr>
                <tr>
                    <th>20</th>
                    <th>40</th>
                    <th>50</th>
                    <th>60</th>
                    <th>บาท</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>432760</td>
                    <td>จงรักษ์ รอดพลอย</td>
                    <td>ห้องสาร/ผลิต</td>
                    <td></td>
                    <td colspan="1"></td>
                    <td colspan="1"></td>
                    <td colspan="1"></td>
                    <td colspan="1">9</td>
                    <td>540</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>510285</td>
                    <td>หวาน จันทร์ปล้อง</td>
                    <td>สโตร์ / คลังสินค้า</td>
                    <td></td>
                    <td colspan="1"></td>
                    <td colspan="1"></td>
                    <td colspan="1"></td>
                    <td colspan="1">11</td>
                    <td>660</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>510285</td>
                    <td>สง่า งามดี</td>
                    <td>L/R</td>
                    <td></td>
                    <td colspan="1"></td>
                    <td colspan="1"></td>
                    <td colspan="1"></td>
                    <td colspan="1">11</td>
                    <td>660</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="9" class="total-label">ยอดรวมค่ากะ</td>
                    <td class="total-amount">1,860</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>