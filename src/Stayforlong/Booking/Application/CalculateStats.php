<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Application;

use Stayforlong\Booking\Domain\BookingCollectionFactory;
use Stayforlong\Booking\Domain\StatsCalculator;

final readonly class CalculateStats
{
    public function __construct(
        private StatsCalculator $statsCalculator,
        private BookingCollectionFactory $bookingCollectionFactory)
    { }

    public function __invoke(CalculateStatsRequest $request): CalculateStatsResponse
    {
        $bookingCollection = $this->bookingCollectionFactory->createFromData($request->data());

        $statsResume = $this->statsCalculator->calculate($bookingCollection);

        return new CalculateStatsResponse(
            avgNight: $statsResume->avg(),
            minNight: $statsResume->min(),
            maxNight: $statsResume->max()
        );
    }
}