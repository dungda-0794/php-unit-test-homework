<?php

namespace Modules\Exercise02\Services;

use Carbon\Carbon;

class ATMService
{
    const NORMAL_FEE = 110;
    const NO_FEE = 0;
    const TIME_PERIOD_1 = ['00:00', '8:44'];
    const TIME_PERIOD_2 = ['08:45', '17:59'];
    const TIME_PERIOD_3 = ['18:00', '23:59'];
    const HOLIDAYS = ['01-01', '30-04', '01-05'];


     /**
     * Calcuate ATM Fee for vip customer
     *
     *
     * @return null
     */
    public function calculateFeeForVipCustomer()
    {
        if ($isVip) {
            return self::NO_FEE;
        }

        // Return normalFee if it is holiday or weekend
        $transactionDate = Carbon::parse($transactionAt);
        if (in_array($transactionDate->format('d-m'), self::HOLIDAYS) || $transactionDate->isWeekend()) {
            return self::NORMAL_FEE;
        }

        $timeNow = $transactionDate->format('H:i');
        list($minTimePeriod2, $maxTimePeriod2) = self::TIME_PERIOD_2;
        if ($timeNow >= $minTimePeriod2 && $timeNow <= $maxTimePeriod2) {
            return self::NO_FEE;
        }

        return self::NORMAL_FEE;
    }

    /**
     * Calcuate ATM Fee
     *
     *
     * @return null
     */
    public function calculateFee($isVip, $transactionAt)
    {
        if ($isVip) {
            return self::NO_FEE;
        }

        // Return normalFee if it is holiday or weekend
        $transactionDate = Carbon::parse($transactionAt);
        if (in_array($transactionDate->format('d-m'), self::HOLIDAYS) || $transactionDate->isWeekend()) {
            return self::NORMAL_FEE;
        }

        $timeNow = $transactionDate->format('H:i');
        list($minTimePeriod2, $maxTimePeriod2) = self::TIME_PERIOD_2;
        if ($timeNow >= $minTimePeriod2 && $timeNow <= $maxTimePeriod2) {
            return self::NO_FEE;
        }

        return self::NORMAL_FEE;
    }
}
