<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HtmlColrsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('html_colors')->insert([
            ['color' => '#fe4a49'],
            ['color' => '#2ab7ca'],
            ['color' => '#fed766'],
            ['color' => '#011f4b'],
            ['color' => '#03396c'],
            ['color' => '#005b96'],
            ['color' => '#051e3e'],
            ['color' => '#251e3e'],
            ['color' => '#451e3e'],
            ['color' => '#651e3e'],
            ['color' => '#851e3e'],
            ['color' => '#4a4e4d'],
            ['color' => '#0e9aa7'],
            ['color' => '#3da4ab'],
            ['color' => '#f6cd61'],
            ['color' => '#fe8a71'],
            ['color' => '#2a4d69'],
            ['color' => '#4b86b4'],
            ['color' => '#63ace5'],
            ['color' => '#009688'],
            ['color' => '#ee4035'],
            ['color' => '#f37736'],
            ['color' => '#7bc043'],
            ['color' => '#0392cf'],
            ['color' => '#4d648d'],
            ['color' => '#283655'],
            ['color' => '#1e1f26'],
            ['color' => '#ff6f69'],
            ['color' => '#ffcc5c'],
            ['color' => '#88d8b0'],
            ['color' => '#6e7f80'],
            ['color' => '#536872'],
            ['color' => '#708090'],
            ['color' => '#536878'],
            ['color' => '#36454f'],
            ['color' => '#4b3832'],
            ['color' => '#854442'],
            ['color' => '#3c2f2f'],
            ['color' => '#be9b7b'],
            ['color' => '#008744'],
            ['color' => '#0057e7'],
            ['color' => '#d62d20'],
            ['color' => '#ffa700'],
            ['color' => '#3385c6'],
            ['color' => '#4279a3'],
            ['color' => '#476c8a'],
            ['color' => '#49657b'],
            ['color' => '#d11141'],
            ['color' => '#00b159'],
            ['color' => '#00aedb'],
            ['color' => '#f37735'],
            ['color' => '#ffc425'],
            ['color' => '#58668b'],
            ['color' => '#5e5656'],
            ['color' => '#ff5588'],
            ['color' => '#ff3377'],
            ['color' => '#29a8ab'],
            ['color' => '#edc951'],
            ['color' => '#eb6841'],
            ['color' => '#cc2a36'],
            ['color' => '#4f372d'],
            ['color' => '#00a0b0'],
            ['color' => '#2e003e'],
            ['color' => '#3d2352'],
            ['color' => '#3d1e6d'],
            ['color' => '#343d46'],
            ['color' => '#3b7dd8']
        ]);
    }
}
