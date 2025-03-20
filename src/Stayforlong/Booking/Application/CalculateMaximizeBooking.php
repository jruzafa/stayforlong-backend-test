<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Application;

use Stayforlong\Booking\Domain\BookingRequestCollectionFactory;
use Stayforlong\Booking\Domain\MaximizeCalculator;

final readonly class CalculateMaximizeBooking
{
    public function __construct(
        private BookingRequestCollectionFactory $bookingCollectionFactory,
        private MaximizeCalculator $calculator
    ) { }

    public function __invoke(array $bookingRequests): CalculateMaximizeBookingResponse
    {
        $bookingCollection = $this->bookingCollectionFactory->createFromData($bookingRequests);

        $stats = $this->calculator->calculate($bookingCollection);

        return new CalculateMaximizeBookingResponse(
            $stats->requestsIds(),
            $stats->totalProfit(),
            $stats->avgNight(),
            $stats->minNight(),
            $stats->maxNight()
        );
    }
}