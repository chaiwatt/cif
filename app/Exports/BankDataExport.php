<?php

namespace App\Exports;

use App\Models\BankData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BankDataExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    /* public function collection()
    {
        return BankData::all();
    } */
    public function collection()
    {
        return collect([
            [
                '006',
                '2080189468',
                'น.ส.มลฤดี  บุญลอย',
                '503.00',
                '0000000000000',
                'xxxx',
                '0000',
                'xxxx',
                '0000000000',
            ],
            [
                '006',
                '2080189069',
                'น.ส.เล็ก  วงษ์ลา',
                '1584.00',
                '0000000000000',
                'xxxx',
                '0000',
                'xxxx',
                '0000000000',
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'Receiving Bank Code',
            'Receiving A/C No.',
            'Receiver Name',
            'Transfer Amount',
            'Citizen ID/Tax ID',
            'DDA Ref',
            'Reference No./ DDA Ref 2',
            'Email',
            'Mobile No.',
        ];
    }
}
