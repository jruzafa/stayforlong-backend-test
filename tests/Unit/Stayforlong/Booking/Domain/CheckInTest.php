<?php

namespace App\Tests\Unit\Stayforlong\Booking\Domain;

use PHPUnit\Framework\TestCase;
use Stayforlong\Booking\Domain\CheckIn;

class CheckInTest extends TestCase
{
    public function testGivenValidDateWhenCreateThenCheckInCreated()
    {
        $checkIn = new CheckIn('2999-01-01');

        self::assertInstanceOf(CheckIn::class, $checkIn);
    }

    public function testGivenInvalidDateWhenCreateThenExceptionThrown()
    {
        $this->expectException(\InvalidArgumentException::class);

        new CheckIn('2000-01-01');
    }
}
