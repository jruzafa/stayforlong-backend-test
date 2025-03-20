<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Application;

use Stayforlong\Booking\Domain\BookingCollectionFactory;
use Stayforlong\Booking\Domain\MaximizeCalculator;

final readonly class CalculateMaximizeBooking
{
    public function __construct(
        private BookingCollectionFactory $bookingCollectionFactory,
        private MaximizeCalculator $calculator
    ) { }

    public function __invoke(array $bookingRequests): CalculateMaximizeBookingResponse
    {
        $bookingCollection = $this->bookingCollectionFactory->createFromData($bookingRequests);

        $stats = $this->calculator->calculate($bookingCollection);

        return new CalculateMaximizeBookingResponse(
            requestsIds: $stats->requestsIds(),
            totalProfit: $stats->totalProfit(),
            avgNight: $stats->avgNight(),
            minNight: $stats->minNight(),
            maxNight: $stats->maxNight()
        );
    }
}