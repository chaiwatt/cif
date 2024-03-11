<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function ssoPayment($id)
    {
        return view('report.sso1');
    }

    public function ssoPaymentMonth($id)
    {
        return view('report.sso2');
    }
}
