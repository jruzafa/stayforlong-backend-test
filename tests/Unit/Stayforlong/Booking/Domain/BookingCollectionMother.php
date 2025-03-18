<?php

declare(strict_types=1);

namespace App\Tests\Unit\Stayforlong\Booking\Domain;

use Stayforlong\Booking\Domain\BookingCollection;
use Stayforlong\Booking\Domain\Margin;
use Stayforlong\Booking\Domain\Nights;
use Stayforlong\Booking\Domain\SellingRate;

final class BookingCollectionMother
{
    public static function case1(): BookingCollection
    {
        $bookingCollection = new BookingCollection([]);
        $bookingCollection->add(
            BookingMother::create(
                null,
                null,
                Nights::createFromInt(4),
                SellingRate::createFromInt(156),
                Margin::createFromInt(22)
            )
        );
        $bookingCollection->add(
            BookingMother::create(
                null,
                null,
                Nights::createFromInt(5),
                SellingRate::createFromInt(200),
                Margin::createFromInt(20)
            )
        );

        return $bookingCollection;
    }

    public static function case2(): BookingCollection
    {
        $bookingCollection = new BookingCollection([]);
        $bookingCollection->add(
            BookingMother::create(
                null,
                null,
                Nights::createFromInt(1),
                SellingRate::createFromInt(50),
                Margin::createFromInt(20)
            )
        );
        $bookingCollection->add(
            BookingMother::create(
                null,
                null,
                Nights::createFromInt(1),
                SellingRate::createFromInt(55),
                Margin::createFromInt(22)
            )
        );
        $bookingCollection->add(
            BookingMother::create(
                null,
                null,
                Nights::createFromInt(1),
                SellingRate::createFromInt(49),
                Margin::createFromInt(21)
            )
        );

        return $bookingCollection;
    }
}