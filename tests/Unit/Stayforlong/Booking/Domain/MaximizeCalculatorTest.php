<?php

namespace App\Tests\Unit\Stayforlong\Booking\Domain;

use PHPUnit\Framework\TestCase;
use Stayforlong\Booking\Domain\BookingRequestCollection;
use Stayforlong\Booking\Domain\MaximizeCalculator;

class MaximizeCalculatorTest extends TestCase
{
    private MaximizeCalculator $maximizeCalculator;

    protected function setUp(): void
    {
        $this->maximizeCalculator = new MaximizeCalculator();
    }

    public function testGivenEmptyCollectionWhenCalculateThenEmptyStatsReturned()
    {
        $collection = new BookingRequestCollection([]);

        $maximizeStats = $this->maximizeCalculator->calculate($collection);

        self::assertEquals(0, $maximizeStats->avgNight());
        self::assertEquals(0, $maximizeStats->minNight());
        self::assertEquals(0, $maximizeStats->maxNight());
        self::assertEmpty($maximizeStats->requestsIds());
    }

    public function testGivenValidCaseWhenCalculateThenExpectedMaximizeStatsReturned()
    {
        $maximizeStats = $this->maximizeCalculator->calculate(BookingCollectionMother::case3());

        self::assertEquals([
            'bookata_XY123',
            'acme_AAAAA'
        ], $maximizeStats->requestsIds());
        self::assertEqualsWithDelta(88, $maximizeStats->totalProfit(), 0.01);
        self::assertEqualsWithDelta(10, $maximizeStats->avgNight(), 0.01);
        self::assertEqualsWithDelta(8, $maximizeStats->minNight(), 0.01);
        self::assertEqualsWithDelta(12, $maximizeStats->maxNight(), 0.01);
    }

    public function testGivenOverlapAllCaseWhenCalculateThenEmptyStatsReturned()
    {
        $maximizeStats = $this->maximizeCalculator->calculate(BookingCollectionMother::caseOverlapAllBookingRequests());

        self::assertEmpty($maximizeStats->requestsIds());
        self::assertEquals(0, $maximizeStats->totalProfit());
        self::assertEquals(0, $maximizeStats->avgNight());
        self::assertEquals(0, $maximizeStats->minNight());
        self::assertEquals(0, $maximizeStats->maxNight());
    }
}
