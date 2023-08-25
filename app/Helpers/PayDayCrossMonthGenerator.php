<?php
namespace App\Helpers;

use Carbon\Carbon;

class PayDayCrossMonthGenerator
{
    public function generateCrossMonthPayDays($startDate, $endDate, $numPayDays, $useEndMonth = true,$numDayToPayment)
    {
        $payDays = [];
        $holidays = [ /* List of holidays in 'Y-m-d' format */ ];

        $currentStartDate = Carbon::parse($startDate);
        $currentEndDate = Carbon::parse($endDate);

        for ($i = 0; $i < $numPayDays; $i++) {
            $paymentDate = $this->calculatePaymentDate($currentEndDate, $holidays, $useEndMonth,$numDayToPayment);
            $currentMonth = $i+1;
            $payDays[] = [
                'month' => $currentMonth,
                'startDate' => $currentStartDate->format('Y-m-d'),
                'endDate' => $currentEndDate->format('Y-m-d'),
                'paymentDate' => $paymentDate->format('Y-m-d'),
            ];

            // Increment by one month
            $currentStartDate->addMonth();
            $currentEndDate->addMonth();
        }

        return $payDays;
    }

    private function calculatePaymentDate($endDate, $holidays, $useEndMonth,$numDayToPayment)
    {
        $paymentDate = $useEndMonth ? $endDate->copy()->endOfMonth() : $endDate->copy()->addDays($numDayToPayment);

        while ($paymentDate->isWeekend() || in_array($paymentDate->format('Y-m-d'), $holidays)) {
            $paymentDate->subDay();

            if ($paymentDate->isSaturday()) {
                $paymentDate->subDay();
            } elseif ($paymentDate->isSunday()) {
                $paymentDate->subDays(2);
            }
        }

        return $paymentDate;
    }
}
