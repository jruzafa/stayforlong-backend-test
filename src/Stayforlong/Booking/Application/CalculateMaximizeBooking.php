<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Application;

use Stayforlong\Booking\Domain\BookingCollectionFactory;
use Stayforlong\Booking\Domain\MaximizeCalculator;

final readonly class CalculateMaximizeBooking
{
    public function __construct(
        private BookingCollectionFactory $bookingCollectionFactory,
        private MaximizeCalculator $calculator
    ) { }

    public function __invoke(CalculateMaximizeBookingRequest $request): array
    {
        $bookingCollection = $this->bookingCollectionFactory->createFromData($request->data());

        return $this->calculator->calculate($bookingCollection);
    }
}