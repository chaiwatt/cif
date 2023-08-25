<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaydayDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payday_details')->insert([
            [
            'payday_id' => 1,
            'month_id' => 1,
            'start_date' => Carbon::createFromFormat('Y-m-d', '2022-12-26'),
            'end_date' => Carbon::createFromFormat('Y-m-d', '2023-01-25'),
            'payment_date' => Carbon::createFromFormat('Y-m-d', '2023-01-31'),
            ],
            [
            'payday_id' => 1,
            'month_id' => 2,
            'start_date' => Carbon::createFromFormat('Y-m-d', '2023-01-26'),
            'end_date' => Carbon::createFromFormat('Y-m-d', '2023-02-25'),
            'payment_date' => Carbon::createFromFormat('Y-m-d', '2023-02-28'),
            ],
            [
            'payday_id' => 1,
            'month_id' => 3,
            'start_date' => Carbon::createFromFormat('Y-m-d', '2023-02-26'),
            'end_date' => Carbon::createFromFormat('Y-m-d', '2023-03-25'),
            'payment_date' => Carbon::createFromFormat('Y-m-d', '2023-03-31'),
            ],
            [
            'payday_id' => 1,
            'month_id' => 4,
            'start_date' => Carbon::createFromFormat('Y-m-d', '2023-03-26'),
            'end_date' => Carbon::createFromFormat('Y-m-d', '2023-04-25'),
            'payment_date' => Carbon::createFromFormat('Y-m-d', '2023-04-30'),
            ],
            [
            'payday_id' => 1,
            'month_id' => 5,
            'start_date' => Carbon::createFromFormat('Y-m-d', '2023-05-26'),
            'end_date' => Carbon::createFromFormat('Y-m-d', '2023-06-25'),
            'payment_date' => Carbon::createFromFormat('Y-m-d', '2023-06-31'),
            ],
            [
            'payday_id' => 1,
            'month_id' => 6,
            'start_date' => Carbon::createFromFormat('Y-m-d', '2023-06-26'),
            'end_date' => Carbon::createFromFormat('Y-m-d', '2023-07-25'),
            'payment_date' => Carbon::createFromFormat('Y-m-d', '2023-07-31'),
            ],
            [
            'payday_id' => 1,
            'month_id' => 7,
            'start_date' => Carbon::createFromFormat('Y-m-d','2023-07-26'),
            'end_date' => Carbon::createFromFormat('Y-m-d', '2023-08-25'),
            'payment_date' => Carbon::createFromFormat('Y-m-d', '2023-08-31'),
            ],
            [
            'payday_id' => 1,
            'month_id' => 8,
            'start_date' => Carbon::createFromFormat('Y-m-d', '2023-08-26'),
            'end_date' => Carbon::createFromFormat('Y-m-d', '2023-09-25'),
            'payment_date' => Carbon::createFromFormat('Y-m-d', '2023-09-30'),
            ],
            [
            'payday_id' => 1,
            'month_id' => 9,
            'start_date' => Carbon::createFromFormat('Y-m-d', '2023-09-26'),
            'end_date' => Carbon::createFromFormat('Y-m-d', '2023-10-25'),
            'payment_date' => Carbon::createFromFormat('Y-m-d', '2023-10-30'),
            ],
            [
            'payday_id' => 1,
            'month_id' => 10,
            'start_date' => Carbon::createFromFormat('Y-m-d', '2023-10-26'),
            'end_date' => Carbon::createFromFormat('Y-m-d', '2023-11-25'),
            'payment_date' => Carbon::createFromFormat('Y-m-d', '2023-11-30'),
            ],
            [
            'payday_id' => 1,
            'month_id' => 11,
            'start_date' => Carbon::createFromFormat('Y-m-d', '2023-11-26'),
            'end_date' => Carbon::createFromFormat('Y-m-d', '2023-12-25'),
            'payment_date' => Carbon::createFromFormat('Y-m-d', '2023-12-31'),
            ],
            [
            'payday_id' => 1,
            'month_id' => 12,
            'start_date' => Carbon::createFromFormat('Y-m-d', '2023-12-26'),
            'end_date' => Carbon::createFromFormat('Y-m-d', '2024-01-25'),
            'payment_date' => Carbon::createFromFormat('Y-m-d', '2023-01-31'),
            ]
        ]);
    }
}
