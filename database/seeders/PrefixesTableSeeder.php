<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PrefixesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('prefixes')->insert([
            [
            'name' =>'นาย'
            ],
            [
            'name' =>'นาง'
            ],
            [
            'name' =>'น.ส.'
            ],
            [
            'name' =>'Mr.'
            ],
            [
            'name' =>'Miss.'
            ],
            [
            'name' =>'Mrs.'
            ]
        ]);
    }
}
