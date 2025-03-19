<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Domain;

final class BookingCollectionFactory
{
    public function createFromData(array $bookings): BookingCollection
    {
        $collection = new BookingCollection([]);

        foreach ($bookings as $bookingData) {
            $collection->add(
                new Booking(
                    RequestId::create($bookingData['request_id']),
                    CheckIn::createFromString($bookingData['check_in']),
                    Nights::createFromInt($bookingData['nights']),
                    SellingRate::createFromInt($bookingData['selling_rate']),
                    Margin::createFromInt($bookingData['margin'])
                )
            );
        }

        return $collection;
    }
}