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
        self::assertEquals(88, $maximizeStats->totalProfit());
        self::assertEquals(10, $maximizeStats->avgNight());
        self::assertEquals(8, $maximizeStats->minNight());
        self::assertEquals(12, $maximizeStats->maxNight());
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
