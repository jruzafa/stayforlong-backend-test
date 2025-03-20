<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Domain;

final class MaximizeCalculator
{
    public function calculate(BookingRequestCollection $bookingRequestCollection): MaximizeStatsResume
    {
        if ($bookingRequestCollection->isEmpty()){
            return MaximizeStatsResume::empty();
        }

        $validBookingCombinations = [];

        foreach ($bookingRequestCollection->getIterator() as $current)
        {
            /** @var BookingRequest $booking */
            foreach ($bookingRequestCollection->getIterator() as $booking) {
                if($booking->id()->equals($current->id())){
                    continue;
                }

                if ($current->overlap($booking)) {
                    continue;
                }

                $totalProfit = $current->profit() + $booking->profit();

                $validBookingCombinations[$totalProfit] = [$current->id(), $booking->id()];
            }
        }

        krsort($validBookingCombinations);

        if (count($validBookingCombinations) > 0) {
            $bestCombination = reset($validBookingCombinations);

            if ($bestCombination) {
                $totalProfitCombination = key($validBookingCombinations);

                $bestCombination = array_map(function (RequestId $id) use ($bookingRequestCollection) {
                    return $bookingRequestCollection->findById($id);
                }, $bestCombination);

                $bookingProfitByNight = array_map(function (BookingRequest $currentBooking) {
                    return $currentBooking->profitByNight();
                }, $bestCombination);

                $totalNights = array_reduce($bestCombination, function (int $total, BookingRequest $currentBooking) {
                    return $total + $currentBooking->nights()->value();
                }, 0);

                $maxNight = max($bookingProfitByNight);
                $minNight = min($bookingProfitByNight);
                $avgByNight = round($totalProfitCombination / $totalNights);

                return new MaximizeStatsResume(
                    requestsIds: array_map(function(BookingRequest $booking) {
                        return $booking->id()->value();
                    }, $bestCombination),
                    totalProfit: $totalProfitCombination,
                    avgNight: $avgByNight,
                    minNight: $minNight,
                    maxNight: $maxNight
                );
            }
        }

        return MaximizeStatsResume::empty();
    }
}