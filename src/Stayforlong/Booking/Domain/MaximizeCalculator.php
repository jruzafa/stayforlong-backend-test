<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Domain;

final class MaximizeCalculator
{
    public function calculate(BookingCollection $bookingCollection): MaximizeStats
    {
        if ($bookingCollection->isEmpty()){
            return MaximizeStats::empty();
        }

        $validBookingCombinations = [];

        /** @var Booking $current */
        $iterator = $bookingCollection->getIterator();

        foreach ($bookingCollection->getIterator() as $current)
        {
            /** @var Booking $booking */
            foreach ($bookingCollection->getIterator() as $booking) {
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

                $bestCombination = array_map(function (RequestId $id) use ($bookingCollection) {
                    return $bookingCollection->findById($id);
                }, $bestCombination);

                $bookingProfitByNight = array_map(function (Booking $currentBooking) {
                    return $currentBooking->profitByNight();
                }, $bestCombination);

                $totalNights = array_reduce($bestCombination, function (int $total, Booking $currentBooking) {
                    return $total + $currentBooking->nights()->value();
                }, 0);

                $maxNight = max($bookingProfitByNight);
                $minNight = min($bookingProfitByNight);
                $avgByNight = round($totalProfitCombination / $totalNights);

                return new MaximizeStats(
                    requestsIds: array_map(function(Booking $booking) {
                        return $booking->id()->value();
                    }, $bestCombination),
                    totalProfit: $totalProfitCombination,
                    avgNight: $avgByNight,
                    minNight: $minNight,
                    maxNight: $maxNight
                );
            }
        }

        return MaximizeStats::empty();
    }
}