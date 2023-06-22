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
        $tableName = 'users';
        $columns = DB::select(DB::raw("SELECT COLUMN_NAME, COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '{$tableName}'"));

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
        ReportField::where('table','report_fields')->where('field','name')->first()->update([
            'status' => 1
        ]);
        ReportField::where('table','report_fields')->where('field','lastname')->first()->update([
            'status' => 1
        ]);
        ReportField::where('table','report_fields')->where('field','company_department')->first()->update([
            'status' => 1
        ]);
        ReportField::where('table','report_fields')->where('field','user_position')->first()->update([
            'status' => 1
        ]);
        ReportField::where('table','report_fields')->where('field','employee_no')->first()->update([
            'status' => 1
        ]);
        ReportField::where('table','report_fields')->where('field','employee_type')->first()->update([
            'status' => 1
        ]);
      
    }
}
