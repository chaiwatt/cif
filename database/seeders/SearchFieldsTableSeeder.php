<?php

namespace Database\Seeders;

use App\Models\SearchField;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SearchFieldsTableSeeder extends Seeder
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
                
                $check = SearchField::where('table','users')->where('field',$columnName)->first();
                if(!$check)
                {
                    SearchField::create([
                        'table' => 'users',
                        'field' => $columnName,
                        'comment' => $columnComment,
                        'type' => $type,
                    ]);
                }
           }
        } 
        SearchField::where('table','users')->where('field','name')->first()->update([
            'status' => 1
        ]);
        SearchField::where('table','users')->where('field','lastname')->first()->update([
            'status' => 1
        ]);
        SearchField::where('table','users')->where('field','company_department')->first()->update([
            'status' => 1
        ]);
        SearchField::where('table','users')->where('field','user_position')->first()->update([
            'status' => 1
        ]);
        SearchField::where('table','users')->where('field','employee_no')->first()->update([
            'status' => 1
        ]);
      
    }
}
