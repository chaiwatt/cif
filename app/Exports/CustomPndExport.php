<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class CustomPndExport implements FromCollection/* , WithMapping, ShouldAutoSize, WithCustomCsvSettings */
{
    protected $data;

    public function __construct()
    {
        $this->data = User::all();
    }

    public function collection()
    {
       /*  return $this->data->map(function ($row) {
            return $row->toArray();
        }); */
        /* return $this->data->map(function ($row) {
            $rowArray = $row->toArray();
            return preg_replace('/["\,]+/', '|', $rowArray);

            str_replace(['","', '"', ',', '\"', '/["]+/'], '|', trim( $value)) ?: '|';
            return array_map(function ($value) {
                return preg_replace('/["\',\r\n]+/', '|', $value);
            }, $rowArray);
        }); */
        return $this->data->map(function ($row) {
            $rowArray = $row->toArray();
            return array_map(function ($value) {
                return str_replace(['","', '"', ',', '\"', '/["]+/'], '|', trim($value)) ?: '|';
            }, $rowArray);
        });
    }
    public function map($row): array
    {
        $mappedRow = [];

        // Add each value to the mapped row array
        foreach ($row as $value) {
            $mappedRow[] = str_replace(['","', '"', ',', '\"', '/["]+/'], '|', trim($value)) ?: '|';
        }

        return $mappedRow;
    }
    public function mapCollection($collection): array
    {
        //return $collection->map([$this, 'map'])->all();
        $mappedRow = [];
        foreach ($row as $value) {
            $mappedRow[] = str_replace(['","', '"', ',', '\"', '/["]+/'], '|', trim($value)) ?: '|';
        }
        return $mappedRow;
    }
    /* public function map($row): array
    {
        $mappedRow = [];
        foreach ($row as $value) {
            $mappedRow[] = str_replace(['","', '"', ',', '\"', '/["]+/'], '|', trim($value)) ?: '|';
        }
        return $mappedRow;
    }



    public function getCsvSettings(): array
    {
        return [
            'delimiter' => '|',
            'line_ending' => "\r\n",
        ];
    } */
}
