<?php

namespace App\Http\Controllers;

use App\Exports\BankDataExport;
use App\Exports\CustomPndExport;
use App\Exports\EmployeeSsoExport;
use App\Helpers\ActivityLogger;
use App\Helpers\AddDefaultWorkScheduleAssignment;
use App\Http\Controllers\Controller;
use App\Models\CompanyDepartment;
use App\Models\Job;
use App\Models\Module;
use App\Models\Month;
use App\Models\Payday;
use App\Models\PaydayDetail;
use App\Models\RoleGroupJson;
use App\Models\SalarySummary;
use App\Models\User;

use App\Services\UpdatedRoleGroupCollectionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Excel as ExcelType;
use Maatwebsite\Excel\Facades\Excel;

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
    public function bis50list()
    {
        $action = 'show';
        $groupUrl = strval(session('groupUrl'));
        $permission = (object)[
            'show' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ];
        /* 'groups.employee-system.employee' */
        /* $updatedRoleGroupCollection = [
            'module_prefix' => 'groups.employee-system.employee',
            'code' => 'EMPLOYEE-MANAGE',
            'name' => 'จัดการ',
            'module_icon' => 'fa-user',
        ]; */
        $viewName = 'report.bis50index';
        $users = User::paginate(50);
        return view($viewName, [
            'groupUrl' => $groupUrl,
            /* 'modules' => $updatedRoleGroupCollection, */
            'permission' => $permission,
            'users' => $users,
        ]);
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
        $data = DB::table('users')->whereId($id)->first();
        if(isset($data) && $data){
            $html = view('report.bis50-2', compact('data'))->render();

            $stylesheet = file_get_contents(public_path('css/report/bis50.css'));
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->WriteHTML($html, 2);

            /* $pdfFilePath = "report_1.pdf";
            $pdfFile = file_get_contents($pdfFilePath); */
            $mpdf->Output("report_1.pdf", 'F');
            ob_end_clean();


            $pdfFilePath = "report_1.pdf";
            $pdfFile = file_get_contents($pdfFilePath);

            return Response::make($pdfFile, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="report_1.pdf"'
            ]);
        }else{
            echo 'not found data';
        }

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
        $data = User::all();
        $html = View::make('report.cashbank', compact('data'))->render();

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

    public function ssofile($id)
    {
        return Excel::download(new EmployeeSsoExport, 'sso.xlsx');
    }
}
