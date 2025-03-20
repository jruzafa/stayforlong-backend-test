<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Application;

use Stayforlong\Booking\Domain\BookingRequestCollectionFactory;
use Stayforlong\Booking\Domain\StatsCalculator;

final readonly class CalculateStats
{
    public function __construct(
        private StatsCalculator $statsCalculator,
        private BookingRequestCollectionFactory $bookingRequestCollectionFactory)
    { }

    public function __invoke(array $bookingRequests): CalculateStatsResponse
    {
        $bookingRequestCollection = $this->bookingRequestCollectionFactory->createFromData($bookingRequests);

        $statsResume = $this->statsCalculator->calculate($bookingRequestCollection);

        return new CalculateStatsResponse(
            avgNight: $statsResume->avg(),
            minNight: $statsResume->min(),
            maxNight: $statsResume->max()
        );
    }
}