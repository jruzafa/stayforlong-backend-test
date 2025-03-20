<?php

namespace App\Tests\Unit\Stayforlong\Booking\Domain;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Stayforlong\Booking\Domain\BookingCollection;
use Stayforlong\Booking\Domain\StatsCalculator;
use Stayforlong\Booking\Domain\StatsResume;

class StatsCalculatorTest extends TestCase
{
    private StatsCalculator $statsCalculator;

    protected function setUp(): void
    {
        $this->statsCalculator = new StatsCalculator();
    }

    #[DataProvider('dataProviderBookingRequests')]
    public function testGivenSomeCasesWhenCalculateThenExpectedStatsReturned(BookingCollection $bookingCollection, StatsResume $expectedStatsResume)
    {
        $statsResumeCalculated = $this->statsCalculator->calculate($bookingCollection);

        self::assertEqualsWithDelta($expectedStatsResume->avg(), $statsResumeCalculated->avg(), 0.01);
        self::assertEqualsWithDelta($expectedStatsResume->min(), $statsResumeCalculated->min(), 0.01);
        self::assertEqualsWithDelta($expectedStatsResume->max(), $statsResumeCalculated->max(), 0.01);
    }

    public static function dataProviderBookingRequests(): array
    {
        return [
            'case 1' => [BookingCollectionMother::case1(), StatsResumeMother::case1()],
            'case 2' => [BookingCollectionMother::case2(), StatsResumeMother::case2()],
            'empty' => [BookingCollectionMother::empty(), StatsResumeMother::empty()]
        ];
    }
}
