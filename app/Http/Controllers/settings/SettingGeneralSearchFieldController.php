<?php

namespace App\Http\Controllers\Settings;

use App\Models\SearchField;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingGeneralSearchFieldController extends Controller
{
    /**
     * แสดงหน้าดูข้อมูลของการค้นหาฟิลด์ทั้งหมด
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // ดึงข้อมูลของการค้นหาฟิลด์ทั้งหมด
        $searchFields = SearchField::all();
        // ส่งข้อมูลไปยังหน้าแสดงผล
        return view('dashboard.general.searchfield.index', [
            'searchFields' => $searchFields
        ]);
    }
}
