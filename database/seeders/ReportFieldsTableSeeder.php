<?php

namespace Database\Seeders;

use App\Models\ReportField;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReportFieldsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rawQuery = "SELECT COLUMN_NAME, COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ?";
        $tableName = 'users';

        $columns = DB::select($rawQuery, [$tableName]);

        foreach ($columns as $column) {
            $columnName = $column->COLUMN_NAME;
            $columnComment = $column->COLUMN_COMMENT;

           if (!empty($columnComment) && !str_contains($columnComment, 'connection')) 
           {
                $type = substr($columnName, -3) === '_id' ? 'foreign' : null;
                if ($type === 'foreign') {
                    $columnName = substr($columnName, 0, -3);
                }
                $check = ReportField::where('table','report_fields')->where('field',$columnName)->first();
                if(!$check)
                {
                    ReportField::create([
                        'table' => 'report_fields',
                        'field' => $columnName,
                        'comment' => $columnComment,
                        'type' => $type,
                    ]);
                }
                
           }
        } 
      
    }
}
