<?php

declare(strict_types=1);

namespace App\Tests\Unit\Stayforlong\Booking\Domain;

use Stayforlong\Booking\Domain\BookingRequest;
use Stayforlong\Booking\Domain\CheckIn;
use Stayforlong\Booking\Domain\Margin;
use Stayforlong\Booking\Domain\Nights;
use Stayforlong\Booking\Domain\RequestId;
use Stayforlong\Booking\Domain\SellingRate;

final class BookingMother
{
    public static function create(
        ?RequestId $requestId = null,
        ?CheckIn $checkIn = null,
        ?Nights $nights = null,
        ?SellingRate $sellingRate = null,
        ?Margin $margin = null
    ): BookingRequest {
        return new BookingRequest(
            $requestId ?? RequestId::random(),
            $checkIn ?? CheckIn::createFromMutable(
                new \DateTime()->add(new \DateInterval('P1D'))
            ),
            $nights ?? Nights::random(),
            $sellingRate ?? SellingRate::random(),
            $margin ?? Margin::random()
        );
    }
}