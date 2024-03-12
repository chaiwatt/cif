<?php

namespace App\Http\Controllers\Settings;

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
    public function store(Request $request) {
        $socialContributionSalary = $request->social_contribution_salary;
        $socialContributionPercent = $request->social_contribution_percent;
        $socialContributionMax = $request->social_contribution_max;
        $bonusTaxPercent = $request->bonus_tax_percent;
        $tagSettingId = $request->tagSettingId;

        TaxSetting::find($tagSettingId)->update([
            'social_contribution_salary' => $socialContributionSalary,
            'social_contribution_percent' => $socialContributionPercent,
            'social_contribution_max' => $socialContributionMax,
            'bonus_tax_percent'=> $bonusTaxPercent,
        ]);

        return redirect()->route('setting.general.tax')->with('เพิ่มสำเร็จ','');
    }
}
