<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\CustomPndExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelType;

use App\Models\User;

class MPDFController extends Controller
{
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
        return view('report.bis50');
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
}
