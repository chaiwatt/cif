<?php
namespace App\Helpers;

use Carbon\Carbon;

class PayDaySameMonthGenerator
{
    public function generateSameMonthPayDays($startDate, $endDate, $numPayDays,$useEndMonth,$numDayToPayment)
    {
        $payDays = [];
        $holidays = [ /* List of holidays in 'Y-m-d' format */ ];

        $currentStartDate = Carbon::parse($startDate);
        $startDay = Carbon::parse($startDate)->day;
        $startYear = Carbon::parse($startDate)->year;
        $endDay = Carbon::parse($endDate)->day;
        $endYear = Carbon::parse($endDate)->year;

        for ($i = 0; $i < $numPayDays; $i++) {
            $currentMonth = $i + 1; // Month index starts from 1

            $currentStartDate = Carbon::create($startYear, $currentMonth, $startDay);
            $currentEndDate = Carbon::create($endYear, $currentMonth, $endDay);

            if ($currentEndDate->month > $currentStartDate->month) {
                $currentEndDate = $currentStartDate->copy()->endOfMonth();
            } else {
                $currentEndDate = Carbon::create($endYear, $currentMonth, $endDay);
            }

            $paymentDate = $useEndMonth ? $currentEndDate->copy()->endOfMonth() : $currentEndDate->copy()->addDays($numDayToPayment);

            $payDays[] = [
                'month' => $currentMonth,
                'startDate' => $currentStartDate->format('Y-m-d'),
                'endDate' => $currentEndDate->format('Y-m-d'),
                'paymentDate' => $paymentDate->format('Y-m-d'),
            ];
        }

        return $payDays;
    }


}




