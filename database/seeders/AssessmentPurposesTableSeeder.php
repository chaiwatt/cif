<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AssessmentPurposesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('assessment_purposes')->insert([
            [
                'name' => 'ประเมินบุคคลประจำปี'
            ],
            [
                'name' => 'ประเมินบุคคลเพื่อเลื่อนตำแหน่ง'
            ],
            [
                'name' => 'ประเมินเพื่อเข้ารับตำแหน่งใหม่'
            ],
            [
                'name' => 'ประเมินการผ่านการทดลองงาน'
            ],
            [
                'name' => 'ประเมินอื่น ๆ'
            ]
        ]);
    }
}
