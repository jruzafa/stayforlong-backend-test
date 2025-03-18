<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Application;

use Stayforlong\Booking\Domain\Booking;
use Stayforlong\Booking\Domain\BookingCollection;
use Stayforlong\Booking\Domain\CheckIn;
use Stayforlong\Booking\Domain\Margin;
use Stayforlong\Booking\Domain\Nights;
use Stayforlong\Booking\Domain\RequestId;
use Stayforlong\Booking\Domain\SellingRate;
use Stayforlong\Booking\Domain\StatsCalculator;

final readonly class CalculateStats
{
    public function __construct(private StatsCalculator $statsCalculator) { }

    public function __invoke(CalculateStatsRequest $request): CalculateStatsResponse
    {
        // @todo: move to factory
        $bookingCollection = new BookingCollection([]);

        foreach ($request->data() as $value) {
            $bookingCollection->add(
                new Booking(
                    RequestId::create($value['request_id']),
                    CheckIn::createFromString($value['check_in']),
                    Nights::createFromInt($value['nights']),
                    SellingRate::createFromInt($value['selling_rate']),
                    Margin::createFromInt($value['margin'])
                )
            );
        }

        $statsResume = $this->statsCalculator->calculate($bookingCollection);

        return new CalculateStatsResponse(
            avgNight: $statsResume->avg(),
            minNight: $statsResume->min(),
            maxNight: $statsResume->max()
        );
    }
}