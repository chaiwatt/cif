<?php

namespace App\Http\Controllers\settings;

use App\Models\SearchField;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;

class SettingGeneralSearchFieldUserController extends Controller
{
    /**
     * อัปเดตการเลือกฟิลด์ในการค้นหา
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // รับค่าฟิลด์ที่เลือก
        $selectedFields = $request->selectField;

        // ดึงข้อมูลฟิลด์ทั้งหมดในตาราง users
        $allFields = SearchField::where('table', 'users')->pluck('id')->toArray();

        // คำนวณฟิลด์ที่ไม่ได้ถูกเลือก
        $unselectedFields = array_diff($allFields, $selectedFields);

        // อัปเดตสถานะของฟิลด์ที่เลือก
        foreach ($selectedFields as $selectedField) {
            $searchField = SearchField::findOrFail($selectedField);
            $searchField->status = 1;
            $searchField->save();
        }

        // อัปเดตสถานะของฟิลด์ที่ไม่ได้ถูกเลือก
        foreach ($unselectedFields as $unselectedField) {
            $searchField = SearchField::findOrFail($unselectedField);
            $searchField->status = 0;
            $searchField->save();
        }

        // กลับไปยังหน้าดูข้อมูลการค้นหาฟิลด์ทั้งหมด
        return redirect()->route('setting.general.searchfield.index');
    }

}
