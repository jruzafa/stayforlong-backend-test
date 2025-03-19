<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Domain;

use DateInterval;

final class Booking
{
    public function __construct(
        private RequestId $id,
        private \DateTimeImmutable $checkin,
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
        return (($this->sellingRate->value() * $this->margin->value() / 100) / $this->nights->value());
    }

    // todo: return datetime
    public function checkOut(): int
    {
        $checkOut = $this->checkin;
        $checkOut = $checkOut->add(new DateInterval('P' . $this->nights->value() . 'D'));

        return $checkOut->getTimestamp();
    }

    // todo: return datetime
    public function checkIn(): int
    {
        return $this->checkin->getTimestamp();
    }

    public function overlap(Booking $bookingCompare): bool
    {
        return $bookingCompare->checkIn() <= $this->checkOut();
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