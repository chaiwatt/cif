<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Report</title>
    <style>
        /* Define table styles */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th, .data-table td {
            border-top: 1px solid #000; /* Add borders to table cells */
            border-bottom: 1px solid #000;
            padding: 8px; /* Add padding for better readability */
        }

        tbody tr,td{
            border: 0px solid #000; /* Add top border to table rows */

            text-align: center;
            border-top: none; /* Remove top border for cells in rows with this class */
            border-bottom: none; /* Remove bottom border for cells in rows with this class */
        }

        tbody tr:last-child{
            border-bottom: 1px solid #000 !important; /* Add bottom border for the last row */
        }
        .date-range {
            overflow: hidden; /* Clear float and contain floated elements */
            width: 100%; /* Ensure full width */
        }
        .date-range {
            display: flex; /* Use flexbox for layout */
            justify-content: space-between; /* Distribute items along the main axis with space-between */
            width: 100%; /* Ensure full width */
        }

        /* Define styles for the date range spans */
        .date-range {
            position: relative; /* Set position to relative */
            width: 100%; /* Ensure full width */
        }

        /* Define styles for the date range spans */
        .date-range span {
            display: inline-block; /* Ensure inline-block display for spans */
        }

        /* Define styles for the page number span */
        .page-number {
            position: absolute; /* Set position to absolute */
            right: 0; /* Align to the right */
            margin-left: 20px !important; /* Add margin to the left (with !important) */
        }

    </style>
</head>
<body>
    <div class="header" style="margin-left: 20px;">
        <h3>บริษัท ฉวีวรรณ อินเตอร์เนชั่นแนลฟู๊ดส์ จำกัด</h3>
        <h3 class="bold">รายงานโอนเงินเข้าทุกธนาคารพร้อมชื่อย่อธนาคาร</h3>
        <div class="date-range" >
            <span>สำรับงวดวันที่ 09/10/2567 ถึง 09/10/2567</span>
            <span class="page-number" style="margin-left: 20px;">หน้าที่ 1 / 10</span>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>ลำดับ</th>
                <th>ชื่อย่อธนาคาร</th>
                <th>เลขที่บัญชี</th>
                <th>รหัสพนักงาน</th>
                <th>ชื่อ-นามสกุล</th>
                <th>ยอดเงิน</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>ktb</td>
                <td>208-0-18946-8</td>
                <td>401741</td>
                <td>น.ส.มลฤดี บุญลอย</td>
                <td>503.00</td>
            </tr>
            <tr>
                <td>2</td>
                <td>ktb</td>
                <td>208-0-18946-8</td>
                <td>401741</td>
                <td>น.ส.มลฤดี บุญลอย</td>
                <td>503.00</td>
            </tr>
            <tr>
                <td>3</td>
                <td>ktb</td>
                <td>208-0-18946-8</td>
                <td>401741</td>
                <td>น.ส.มลฤดี บุญลอย</td>
                <td>503.00</td>
            </tr>
            <tr>
                <td>4</td>
                <td>ktb</td>
                <td>208-0-18946-8</td>
                <td>401741</td>
                <td>น.ส.มลฤดี บุญลอย</td>
                <td>503.00</td>
            </tr>
            <tr>
                <td>5</td>
                <td>ktb</td>
                <td>208-0-18946-8</td>
                <td>401741</td>
                <td>น.ส.มลฤดี บุญลอย</td>
                <td>503.00</td>
            </tr>
            <!-- Add more rows as needed -->
        </tbody>
    </table>
</body>
</html>
