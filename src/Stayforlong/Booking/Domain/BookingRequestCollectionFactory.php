<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Domain;

final class BookingRequestCollectionFactory
{
    public function createFromData(array $bookings): BookingRequestCollection
    {
        $collection = new BookingRequestCollection([]);

        foreach ($bookings as $bookingData) {
            $collection->add(
                new BookingRequest(
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