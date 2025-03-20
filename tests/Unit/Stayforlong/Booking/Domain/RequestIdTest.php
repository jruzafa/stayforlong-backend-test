<?php

namespace App\Tests\Unit\Stayforlong\Booking\Domain;

use PHPUnit\Framework\TestCase;
use Stayforlong\Booking\Domain\RequestId;

class RequestIdTest extends TestCase
{
    public function testGivenValidRequestIdWhenCreateThenExpectedRequestIdReturned()
    {
        $requestId = new RequestId('bookata_XY123');

        self::assertEquals('bookata_XY123', $requestId->value());
    }

    public function testGivenInValidRequestIdWhenCreateThenExceptionReturned()
    {
        self::expectException(\InvalidArgumentException::class);

        new RequestId('11111');
    }
}
