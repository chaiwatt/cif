<?php

namespace Database\Seeders;

use App\Models\EducationBranch;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EducationBranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createDefaultEducationBrance();
    }

    public function createDefaultEducationBrance()
    {
        $branches = [
            [
                'name' => 'ครุศาสตร์บัณฑิต'
            ],
            [
                'name' => 'เทคโนโลยีชีวภาพ'
            ],
            [
                'name' => 'เทคโนโลยีชีวภาพอุตสาหกรรมเกษตร'
            ],
            [
                'name' => 'วิทยาศาสตร์และเทคโนโลยีอาหาร'
            ],
            [
                'name' => 'พืชสวน'
            ],
            [
                'name' => 'วิทยาศาสตร์การอาหาร'
            ],
            [
                'name' => 'ดุริยางคศิลป์ไทย'
            ],
            [
                'name' => 'รัฐประศาสตร์'
            ]
        ];

        foreach ($branches as $branche) {
            $educationBrance = new EducationBranch();
            $educationBrance->name = $branche['name'];
            $educationBrance->save();
        }
    }
}
