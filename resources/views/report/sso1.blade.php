@extends('layouts.app')

@section('content')
    {{-- Css --}}
    <link href="{{ asset('/css/report-2.css?v=2') }}" rel="stylesheet">

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

    <div id="pdfContent" class="container">
        <div class="wrapper" style="padding: 10px;">
            <div class="wrap-header" style="width: 100%; display: table; clear: both;">
                <div class="logo" style="width: 10%; float: left;">
                    <img src="https://sso.icntracking.com/home/images/logo.png" alt="" style="width: 100%;">
                </div>
                <div class="wrap-name" style="width: 76%; float: left; font-size: 20px; font-weight: 500; text-align: center;">
                    แบบรายการแสดงการส่งเงินสมทบ
                </div>
                <div class="wrap-number" style="width: 14%; float: right; font-size: 16px; font-weight: 500;">
                    สปส. 1-10 (ส่วนที่ 999)
                </div>
            </div>
            <div style="width: 100%; display: block;">
                <span style="font-size: 16px; font-weight: 500;">ชื่อสถานประกอบการ          </span>
                <span style="font-size: 16px; font-style: italic;">บริษัทฉวีวรรณ อินเตอร์เนชั่นแนลฟู๊ดส์ จำกัด</span>
            </div>
            <div style="float: left; width: 70%; display: block;">
                <span style="font-size: 16px; font-weight: 500;">ชื่อสาขา (ถ้ามี)                  </span>
                <span style="font-size: 16px; font-style: italic;">สำนักงานใหญ่</span>
                <br>
                <span style="font-size: 16px; font-weight: 500;">ที่ตั้งสำนักงานใหญ่/สาขา      </span>
                <span style="font-size: 16px; font-style: italic;">83/5 ม.10 ต.หนองขาม อ.ศรีราชา .ชลบุรี โปรดกรอกให้ตรงตามใบ ภพ.20</span>
            </div>
            <div style="float: right; width: 30%; display: block;">
                <span style="font-size: 16px; font-weight: 500;">เลขที่บัญชี                   </span>
                <span style="font-size: 16px;">20-0001201-9</span>
                <br>
                <span style="font-size: 16px; font-weight: 500;">ลำดับที่สาขา                </span>
                <span style="font-size: 16px;">0000000</span>
                <br>
                <span style="font-size: 16px; font-weight: 500;">อัตราเงินสมทบร้อยละ     </span>
                <span style="font-size: 16px;">5.00</span>
            </div>
            <div style="width: 100%; display: block;">
                <span style="font-size: 16px; font-weight: 500;">รหัสไปรษณีย์    </span>
                <span style="font-size: 16px;">20230</span>
                          
                <span style="font-size: 16px; font-weight: 500;">โทรศัพท์    </span>
                <span style="font-size: 16px;">038111630</span>
            </div>
            <div class="table" style="width: 50%; float: left;">
                <table style="width: 90%; border: 1px solid #000">
                    <tbody>
                        <tr style="border: 1px solid #000;">
                            <td colspan="2" style="font-size: 16px;">การนำส่งเงินสมทบสำหรับค่าจ้างเดือน    ธันวาคม พ.ศ. 2023</td>
                        </tr>
                        <tr style="border: 1px solid #000;">
                            <td style="text-align: center; border: 1px solid #000;">รายการ</td>
                            <td style="text-align: center; border: 1px solid #000;">จำนวนเงิน</td>
                        </tr>
                        <tr>
                            <td style="border-left: 1px solid #000; padding: 5px;">1. เงินค่าจ้างทั้งสิ้น</td>
                            <td style="border-left: 1px solid #000; padding: 5px;">2,169,460.00</td>
                        </tr>
                        <tr>
                            <td style="border-left: 1px solid #000; padding: 5px;">2. เงินสมทบผู้ประกันตน</td>
                            <td style="border-left: 1px solid #000; padding: 5px;">108,743.00</td>
                        </tr>
                        <tr>
                            <td style="border-left: 1px solid #000; padding: 5px;">3. เงินสมทบนายจ้าง</td>
                            <td style="border-left: 1px solid #000; padding: 5px;">108,743.00</td>
                        </tr>
                        <tr>
                            <td style="border-left: 1px solid #000; padding: 5px;">4. รวมเงินสมทบนำส่งทั้งสิ้น</td>
                            <td style="border-left: 1px solid #000; padding: 5px;">216,946.00</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding: 5px;">  (สองแสนหนึ่งหมื่นหกพันเก้าร้อยสี่สิบหกบาทถ้วน)</td>
                        </tr>
                        <tr>
                            <td style="border-left: 1px solid #000; padding: 5px;">5. จำนวนผู้ประกันตนที่ส่งเงินสมทบ</td>
                            <td style="border-left: 1px solid #000; padding: 5px;">148</td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <p style="font-size: 16px; font-weight: 500;">ข้าพเจ้าขอรับรองว่ารายการที่แจ้งไว้เป็นรายการที่ถูกต้องครบถ้วนและเป็นจริงทุกประการ</p>
                <p style="font-size: 16px; font-weight: 500;">พร้อมได้แนบ</p>
                <input type="checkbox">    <span>รายละเอียดการนำส่งเงินสมทบ</span>    <span>จำนวน</span>    <span style="border-bottom: 1px dotted #000;">999</span>    <span>แผ่น หรือ</span>
                <br>
                <input type="checkbox">    <span>แผ่นจากแม่เหล็ก</span>                     <span>จำนวน</span>    <span style="border-bottom: 1px dotted #000;">999</span>    <span>แผ่น</span>
                <div style="padding: 30px;">
                    <div style="width: 20%; float: left; text-align: center;">
                        <span style="font-size: 12px; color: #cccccc;">
                            ประทับตรา
                            <br>
                            นิติบุคคล
                            <br>
                            (ถ้ามี)
                        </span>
                    </div>
                    <div style="width: 80%; float: right;">
                        <span style="font-size: 12px;">ลงชื่อ   </span>
                        <span style="border-bottom: 1px dotted #000;">         ช่องใส่ result         </span>
                        <span style="font-size: 12px;">   นายจ้าง/ผู้มอบอำนาจ</span>
                        <br><br>
                        <div>
                            (...........................................................................)
                        </div>
                        <span style="font-size: 12px;">ตำแหน่ง   </span>
                        <span style="border-bottom: 1px dotted #000;">         ช่องใส่ result         </span>
                        <br>
                        <span style="font-size: 12px;">ยื่นแบบวันที่   </span>
                        <span style="border-bottom: 1px dotted #000;">24<span>   เดือน   </span>กุมภาพันธ์<span>   พ.ศ.   </span>2567</span>
                    </div>
                </div>
            </div>
            <div class="table" style="width: 50%; float: right;">
                <table style="width: 100%; border: 1px solid #000">
                    <tbody>
                        <tr style="border: 1px solid #000;">
                            <td style="font-size: 18px; text-align: center;">สำหรับเจ้าหน้าที่ประกันสังคม</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <span>ชำระเงินวันที่    </span>
                                <span style="border-bottom: 1px dotted #000;">ช่องใส่ result</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <span>เงินเพิ่ม (ถ้ามี)   </span>
                                <span style="border-bottom: 1px dotted #000;">
                                    999<span>  บาท  </span>99<span>  สตาง</span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <span>ใบเสร็จรับเงินเล่มที่   </span>
                                <span style="border-bottom: 1px dotted #000;">
                                    2<span>  เลขที่  </span>1
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <span>ลงชื่อ   </span>
                                <span style="border-bottom: 1px dotted #000;">
                                    result
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <center>
                                    (.................................................................................................)
                                </center>
                            </td>
                        </tr>
                        <tr style="border: 1px solid #000;">
                            <td style="font-size: 18px; text-align: center;">สำหรับเจ้าหน้าธนาคาร</td>
                        </tr>
                        <tr style="border: 1px solid #000;">
                            <td style="padding: 5px;">
                                <span>ชำระเงินวันที่   </span>
                                <span style="border-bottom: 1px dotted #000;">
                                    29/02/2024
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <span>ใบนำฝากและใบเสร็จรับเงินเล่มที่   </span>
                                <span style="border-bottom: 1px dotted #000;">
                                    999<span>  เลขที่  </span>99
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <span>ประทับตราธนาคาร   </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <span>ลงชื่อ   </span>
                                <span style="border-bottom: 1px dotted #000;">
                                    result
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <center>
                                    (.................................................................................................)
                                </center>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @php
        $html=ob_get_contents();
        $stylesheet = file_get_contents('css/report/sso1.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html,2);
        /* $mpdf->Output("sso1-".$id.".pdf"); */
        $pdfFilePath = "sso1-".$id.".pdf";
        $mpdf->Output($pdfFilePath, 'F');
        ob_end_clean();
    @endphp

    <div class="container" style="margin-top: 5rem;">
        <a href="../../../{{ $pdfFilePath }}" target="_blank">
            <button id="viewPdfButton ">View PDF แบบแสดงรายการแสดงการส่งเงินสมทบ</button>
        </a>
    </div>
    <script>
        document.getElementById("viewPdfButton").addEventListener("click", function() {
         var pdfFilePath = "<?= $pdfFilePath ?>";
         window.open(pdfFilePath, "_blank");
         document.getElementById("pdfContent").style.display = "block";
     });
     </script>


@endsection
