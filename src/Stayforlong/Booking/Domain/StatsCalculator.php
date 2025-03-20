<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Domain;

final readonly class StatsCalculator
{
    public function calculate(BookingCollection $bookingRequestCollection): StatsResume
    {
        $totalProfit = 0;
        $min = PHP_INT_MAX;
        $max = 0;

        /** @var Booking $booking */
        foreach ($bookingRequestCollection as $booking) {
            $totalProfit += $booking->profitByNight();

            if ($booking->profitByNight() < $min) {
                $min = $booking->profitByNight();
            }

            if ($booking->profitByNight() > $max) {
                $max = $booking->profitByNight();
            }
        }

        if ($totalProfit === 0) {
            return StatsResume::empty();
        }

        $avg = $totalProfit / $bookingRequestCollection->count();

        return new StatsResume(
            avg: $avg,
            min: $min,
            max: $max
        );
    }
}