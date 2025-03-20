<?php

declare(strict_types=1);

namespace App\Tests\Unit\Stayforlong\Booking\Domain;

use Stayforlong\Booking\Domain\BookingCollection;
use Stayforlong\Booking\Domain\CheckIn;
use Stayforlong\Booking\Domain\Margin;
use Stayforlong\Booking\Domain\Nights;
use Stayforlong\Booking\Domain\RequestId;
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

    public static function case3(): BookingCollection
    {
        $bookingCollection = new BookingCollection([]);

        $bookingCollection->add(
            BookingMother::create(
                RequestId::create('acme_AAAAA'),
                CheckIn::createFromString('2026-01-10'),
                Nights::createFromInt(4),
                SellingRate::createFromInt(160),
                Margin::createFromInt(30)
            )
        );
        $bookingCollection->add(
            BookingMother::create(
                RequestId::create('bookata_XY123'),
                CheckIn::createFromString('2026-01-01'),
                Nights::createFromInt(5),
                SellingRate::createFromInt(200),
                Margin::createFromInt(20)
            )
        );
        $bookingCollection->add(
            BookingMother::create(
                RequestId::create('kayete_PP234'),
                CheckIn::createFromString('2026-01-04'),
                Nights::createFromInt(4),
                SellingRate::createFromInt(156),
                Margin::createFromInt(22)
            )
        );
        $bookingCollection->add(
            BookingMother::create(
                RequestId::create('atropote_AA930'),
                CheckIn::createFromString('2026-01-04'),
                Nights::createFromInt(4),
                SellingRate::createFromInt(150),
                Margin::createFromInt(6)
            )
        );

        return $bookingCollection;
    }

    public static function caseOverlapAllBookingRequests(): BookingCollection
    {
        $bookingCollection = new BookingCollection([]);

        $bookingCollection->add(
            BookingMother::create(
                RequestId::create('acme_AAAAA'),
                CheckIn::createFromString('2026-01-01'),
                Nights::createFromInt(2),
                SellingRate::createFromInt(160),
                Margin::createFromInt(30)
            )
        );
        $bookingCollection->add(
            BookingMother::create(
                RequestId::create('bookata_XY123'),
                CheckIn::createFromString('2026-01-01'),
                Nights::createFromInt(2),
                SellingRate::createFromInt(200),
                Margin::createFromInt(20)
            )
        );
        $bookingCollection->add(
            BookingMother::create(
                RequestId::create('kayete_PP234'),
                CheckIn::createFromString('2026-01-01'),
                Nights::createFromInt(2),
                SellingRate::createFromInt(156),
                Margin::createFromInt(22)
            )
        );

        return $bookingCollection;
    }

    public static function empty(): BookingCollection
    {
        return new BookingCollection([]);
    }
}