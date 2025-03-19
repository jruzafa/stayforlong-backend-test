<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Domain;

final class MaximizeCalculator
{
    public function calculate(BookingCollection $bookingCollection): array
    {
        $validBookingCombinations = [];

        /** @var Booking $current */
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
                    return $currentBooking->profit() / $currentBooking->nights()->value();
                }, $bestCombination);

                $totalNights = array_reduce($bestCombination, function (int $carry, Booking $currentBooking) {
                    return $carry + $currentBooking->nights()->value();
                }, 0);

                $maxNight = max($bookingProfitByNight);
                $minNight = min($bookingProfitByNight);
                $avgByNight = round($totalProfitCombination / $totalNights);

                return [
                    'request_ids' => array_map(function(Booking $reserva) {
                        return $reserva->id()->value();
                    }, $bestCombination),
                    'total_profit' => $totalProfitCombination,
                    'avg_night' => $avgByNight,
                    'min_night' => $minNight,
                    'max_night' => $maxNight
                ];
            }
        }

        // todo: call to factory method
        return [
            'request_ids' => [],
            'total_profit' => 0,
            'avg_night' => 0,
            'min_night' => 0,
            'max_night' => 0
        ];
    }
}