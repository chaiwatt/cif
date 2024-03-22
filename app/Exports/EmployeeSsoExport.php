<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class EmployeeSsoExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = User::get();
        $returndata = [];

        foreach ($data as $item) {
            $rowData = [
                'passport' => $item->nationality_id,
                'prefix' => $item->prefix->name,
                'name' => $item->name,
                'lastname' => $item->name, // This might be incorrect, should it be $item->lastname?
                'bank_account' => $item->bank_account,
                'bank' => $item->bank,
            ];

            $returndata[] = $rowData;
        }

        return collect($returndata);
    }

    public function headings(): array
    {
        return [
            'เลขประจำตัวประชาชน',
            'คำนำหน้าชื่อ',
            'ชื่อผู้ประกันตน',
            'นามสกุลผู้ประกันตน',
            'ค่าจ้าง',
            'จำนวนเงินสมทบ',
        ];
    }

    public function encoding(): string
    {
        return 'UTF-8';
    }

    public function title(): string
    {
        return '000000';
    }
}
