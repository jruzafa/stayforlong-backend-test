<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Domain;

use DateInterval;
use DateTimeImmutable;

final class BookingRequest
{
    public function __construct(
        private RequestId $id,
        private DateTimeImmutable $checkin,
        private Nights $nights,
        private SellingRate $sellingRate,
        private Margin $margin
    ) {}

    public function profit(): float
    {
        return (($this->sellingRate->value() * $this->margin->value() / 100));
    }

    public function profitByNight(): float
    {
        return ($this->profit() / $this->nights->value());
    }

    public function checkOut(): DateTimeImmutable
    {
        $checkOut = $this->checkin;
        $checkOut = $checkOut->add(new DateInterval('P' . $this->nights->value() . 'D'));

        return $checkOut;
    }

    public function checkIn(): DateTimeImmutable
    {
        return $this->checkin;
    }

    public function overlap(BookingRequest $bookingCompare): bool
    {
        return $bookingCompare->checkIn()->getTimestamp() <= $this->checkOut()->getTimestamp();
    }

    public function nights(): Nights
    {
        return $this->nights;
    }

    public function id(): RequestId
    {
        return $this->id;
    }
}