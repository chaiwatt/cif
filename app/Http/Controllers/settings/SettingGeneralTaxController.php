<?php

namespace App\Http\Controllers\settings;

use App\Models\TaxSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingGeneralTaxController extends Controller
{
    public function index()
    {
         // ดึงข้อมูลแผนกของบริษัททั้งหมดจากฐานข้อมูล
        $taxSetting = TaxSetting::first();

        // ส่งข้อมูลแผนกไปยังวิวเพื่อแสดงผล
        return view('setting.general.tax.index', [
            'taxSetting' => $taxSetting
        ]);
    }
}
