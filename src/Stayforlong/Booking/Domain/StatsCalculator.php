<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Domain;

final readonly class StatsCalculator
{
    public function calculate(BookingCollection $bookingRequestCollection): StatsResume
    {
        $total = 0;
        $min = PHP_INT_MAX;
        $max = 0;

        /** @var Booking $booking */
        foreach ($bookingRequestCollection as $booking) {
            $total += $booking->nonProfit();
            $min = min($min, $booking->nonProfit());
            $max = max($max, $booking->nonProfit());
        }

        if ($total === 0) {
            return new StatsResume(
                avg: 0,
                min: 0,
                max: 0
            );
        }

        $avg = $total / $bookingRequestCollection->count();

        return new StatsResume(
            avg: $avg,
            min: $min,
            max: $max
        );
    }
}