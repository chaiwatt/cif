<?php

namespace App\Http\Controllers\settings;

use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingReportUserController extends Controller
{
    /**
     * แสดงหน้าตารางสำหรับการออกรายงาน
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ['title' => 'ตัวอย่าง', 'body' => 'test'];
        $pdf = PDF::loadView('dashboard.report.user.user-report', $data);
        return $pdf->stream('document.pdf');
    }
}
