@extends('layouts.app')

@section('content')
    {{-- Css --}}
    <link href="{{ asset('/css/report-3.css?v=2') }}" rel="stylesheet">

    @php
        include '../vendor/autoload.php';
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new \Mpdf\Mpdf([
            'fontDir' => array_merge($fontDirs, [
                // __DIR__ . '/tmp',
                storage_path('fonts/'),
            ]),
            'fontdata' => $fontData + [
                'sarabun' => [
                    'R' => 'THSarabunNew.ttf',
                    'I' => 'THSarabunNew Italic.ttf',
                    'B' => 'THSarabunNew Bold.ttf',
                ]
            ],
            'default_font' => 'sarabun',
            'mode' => 'utf-8','format' => 'A4','margin_left' => 0,'margin_right' => 0,'margin_top' => 0,'margin_bottom' => 0,'margin_header' => 0,'margin_footer' => 0
        ]);

        ob_start();
    @endphp

    <div class="container" style="padding: 10px;">
        <div class="wrap-header">
            <div class="wrap-title" style="width: 50%; float: left; font-size: 20px;">แบบรายการแสดงการส่งเงินสมทบ (สปส.1-10)(ตามแนวตั้ง)</div>
            <div class="wrap-number" style="width: 10%; float: right; text-align-last: right;">สปส.1-10 (ส่วนที่2)</div>
        </div>
        <div style="width: 65%; float: left;">
            <span style="font-size: 16px;">สำหรับค่าจ้างเงินเดือน    </span><span style="font-size: 16px;">ธันวาคม พ.ศ. 2023</span>
            <br>
            <span style="font-size: 16px;">ชื่อสถานประกอบการ     </span><span style="font-size: 16px; font-style: italic;">บริษัท ฉวีวรรณ อินเตอร์เนชั่นแนลฟู๊ดส์ จำกัด</span>
        </div>
        <div style="width: 23%; float: right;">
            <span>แผ่นที่     </span><span>1</span><span>     ในจำนวน     </span><span>100</span><span>     แผ่น</span>
            <br>
            <span>เลขที่บัญชี</span><span>      </span><span>2000012019</span>
            <br>
            <span>ลำดับที่สาขา</span><span>   </span><span>000000</span>
        </div>
        <div style="width: 100%; display: block; ">
            <span>เพื่อประโยชน์ในการใช้สิทธิ์ขอรับประโยชน์ทดแทนของผู้ประกันตน ทุกครั้งที่นำส่งเงินสมทบ กรอกรายการให้ครบถ้วนถูกต้อง และชัดเจนด้วยลายมือตัวบรรจงหรือพิมพ์ดีด ให้แสดงรายการเฉพาะผู้ประกันตนที่มีค่าจ้าง ผู้ที่ไม่มีค่าจ้าง ไม่ต้องแสดง</span>
        </div>
        <table class="table-report">
            <thead>
                <tr style="border-bottom: 1px solid #000;">
                    <th style="border: 1px solid #000; text-align: center;">1</th>
                    <th style="border: 1px solid #000; text-align: center;">2</th>
                    <th style="border: 1px solid #000; text-align: center;">3</th>
                    <th style="border: 1px solid #000; text-align: center;">4</th>
                    <th style="border: 1px solid #000; text-align: center;">5</th>
                </tr>
            </thead>
            <tbody>
                <tr style="border-bottom: 1px solid #000;">
                    <th style="border: 1px solid #000; text-align: center; vertical-align: middle; padding: 2px;">ลำดับที่</th>
                    <th style="border: 1px solid #000; text-align: center; vertical-align: middle; padding: 2px;">เลขประจำตัวประชาชน</th>
                    <th style="border: 1px solid #000; text-align: center; vertical-align: middle; padding: 2px;">คำนำหน้าบนชื่อ-ชื่อสกุลผู้ประกันตน</th>
                    <th style="border: 1px solid #000; text-align: center; vertical-align: middle; padding: 2px;">ค่าจ้าง<br>(ไม่ต่ำกว่า 1,650 -<br>ไม่เกิน 15,000)</th>
                    <th style="border: 1px solid #000; text-align: center; vertical-align: middle; padding: 2px;">เงินสมทบ<br>ผู้ประกันตน</th>
                </tr>
                {{-- foreach ตรงนี้ --}}
                @for ($i=1; $i<=20; $i++)
                    <tr>
                        <td class="text-center" style="border-left: 1px solid #000;">{{$i}}</td>
                        <td style="border-left: 1px solid #000;">0-0190-11207-95-5</td>
                        <td style="border-left: 1px solid #000;">น.ส.THIRIAUNG -</td>
                        <td class="text-center" style="border-left: 1px solid #000;">7,520.00</td>
                        <td class="text-center" style="border-left: 1px solid #000;">376.00</td>
                    </tr>
                @endfor
                {{-- End foreach ตรงนี้ --}}
            </tbody>
        </table>
    </div>

    @php
        $html=ob_get_contents();
        $stylesheet = file_get_contents('css/report/sso2.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html,2);
        $mpdf->Output("report_3.pdf");
        ob_end_flush();
    @endphp

    <div class="container" style="margin-top: 5rem;">
        <a href="report_3.pdf" target="_blank">
            <button>
                View PDF
            </button>
        </a>
    </div>

@endsection
