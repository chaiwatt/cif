<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Month;
use App\Models\Payday;
use App\Models\PaydayDetail;
use Illuminate\Http\Request;
use App\Models\SalarySummary;
use App\Helpers\ActivityLogger;
use App\Exports\CustomPndExport;
use App\Models\CompanyDepartment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use App\Exports\BankDataExport;

use Maatwebsite\Excel\Excel as ExcelType;
use App\Helpers\AddDefaultWorkScheduleAssignment;
use App\Services\UpdatedRoleGroupCollectionService;

class MPDFController extends Controller
{

    public function index()
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'show'
        $action = 'show';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));


        $salarySummaries = SalarySummary::all();
        $year = Carbon::now()->year;;
        $paydayDetails = PaydayDetail::whereHas('payday', function ($query) use ($year) {
                    $query->where('year', $year);
                })->get();

        $previousMonth = Carbon::now()->month-1;
        $currentPaydayDetailIds = PaydayDetail::where(function ($query) use ($previousMonth,$year) {
            $query->whereHas('payday', function ($subQuery) use ($year) {
                $subQuery->where('cross_month', 2)
                        ->where('year', $year);
            })->whereMonth('start_date', $previousMonth);

            $query->orWhere(function ($query) use ($previousMonth,$year) {
                $query->whereHas('payday', function ($subQuery) use ($year) {
                    $subQuery->where('cross_month', 1)
                    ->where('year', $year);
                })->whereMonth('start_date', $previousMonth - 1);
            });
        })
        ->pluck('id')
        ->toArray();
        $previousPaydayDetails = PaydayDetail::whereIn('id',$currentPaydayDetailIds)->get();
        $month = Month::find($previousMonth);

        $paydays = Payday::where('year',$year)->get();

        return view('report.index', []);
    }
    //
    public function generate()
    {
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $html = view('mpdf/pdf1')->render();
        $mpdf = new \Mpdf\Mpdf([
            'margin_top' => 10,
            'margin_left' => 8,
            'margin_right' => 8,
            'fontDir' => array_merge($fontDirs, [
                public_path('font'),
            ]),
            'fontdata' => $fontData + [
                    'thsarabun' => [
                        'R' => 'THSarabunNew.ttf',
                        'I' => 'THSarabunNew Italic.ttf',
                        'B' => 'THSarabunNew Bold.ttf',
                    ]
                ],
                'default_font' => 'thsarabun'
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        return $mpdf->Output();
    }

    public function bis50($id)
    {
        include '../vendor/autoload.php';
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new \Mpdf\Mpdf([
            'fontDir' => array_merge($fontDirs, [
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
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_header' => 0,
            'margin_footer' => 0
        ]);

        ob_start();

        // Render HTML content
        $html = view('report.bis50-2')->render();

        // Load CSS stylesheet
        $stylesheet = file_get_contents(public_path('css/report/bis50.css'));

        // Write HTML content and CSS to PDF
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html, 2);

        // Save PDF to file
        $pdfFilePath = "report_1.pdf";
        $pdfFile = file_get_contents($pdfFilePath);
        $mpdf->Output($pdfFilePath, 'F');
        ob_end_clean();

        return Response::make($pdfFile, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="report_1.pdf"'
        ]);
        /* include '../vendor/autoload.php';
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new \Mpdf\Mpdf([
            'fontDir' => array_merge($fontDirs, [
                storage_path('fonts/'),
            ]),
            'debug' => true,
            'fontdata' => $fontData + [
                'sarabun' => [
                    'R' => 'THSarabunNew.ttf',
                    'I' => 'THSarabunNew Italic.ttf',
                    'B' => 'THSarabunNew Bold.ttf',
                ]
            ],
            'default_font' => 'sarabun',
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_header' => 0,
            'margin_footer' => 0
        ]);

        ob_start();

        // Render HTML content
        $html = View::make('report.bis50-2')->render();

        // Load CSS stylesheet
        $stylesheet = file_get_contents(public_path('css/report/bis50.css'));

        // Create MPDF instance
        $mpdf = new \Mpdf\Mpdf();

        // Write HTML content and CSS to PDF
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html, 2);

        // Output the PDF as a response
        $pdfFile = $mpdf->Output('', 'S'); // Output as a string
        return Response::make($pdfFile, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="report_1.pdf"'
        ]); */
    }

    public function pnd($id)
    {
        $data = User::all();

        $filePath = public_path($id.'pnd');
        $file = fopen($filePath, 'w');
        foreach ($data as $item) {
            $line = implode('|', $item->toArray());
            fwrite($file, $line . PHP_EOL);
        }

        fclose($file);
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function ssoPayment($id)
    {
        return view('report.sso1', compact('id'));
    }

    public function ssoPaymentMonth($id)
    {
        return view('report.sso2', compact('id'));
    }

    public function rd1($id)
    {
        return view('report.rd1', compact('id'));
    }

    public function rd2($id)
    {
        return view('report.rd2', compact('id'));
    }

    public function cashBank($id)
    {
        include '../vendor/autoload.php';
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new \Mpdf\Mpdf([
            'fontDir' => array_merge($fontDirs, [
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
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 5,
            'margin_bottom' => 5,
            'margin_header' => 0,
            'margin_footer' => 3
        ]);
        $html = View::make('report.cashbank')->render();

        // Create an instance of mPDF

        // Set headers and footers
        /* $mpdf->SetHeader('บริษัท ฉวีวรรณ อินเตอร์เนชั่นแนลฟู๊ดส์ จำกัด'); */
        $mpdf->SetHTMLFooter('<div style="margin:20px 30px 20px 20px; font-size: 14px; text-align: left; border: 0;"><b>พิมพ์วันที่</b> &nbsp;&nbsp;&nbsp;&nbsp;  {DATE j/m/Y H:i} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>รายงานโดย</b> &nbsp;&nbsp; business &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>แฟ้มรายงาน</b> file path</div>');


        // Write PDF content
        $mpdf->WriteHTML($html);

        // Output the PDF
        $mpdf->Output('bank.pdf', 'I');
        /* return view('report.sso2', compact('id')); */
        ob_end_clean();
        $pdfFilePath = "bank.pdf";
        $pdfFile = file_get_contents($pdfFilePath);
        return Response::make($pdfFile, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="report_1.pdf"'
        ]);
    }

    public function ipay($id)
    {
        return Excel::download(new BankDataExport, 'bank_data.xlsx');
    }
}
