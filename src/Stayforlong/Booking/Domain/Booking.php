<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Domain;

final class Booking
{
    public function __construct(
        private RequestId $id,
        private \DateTimeImmutable $checkin,
        private Nights $nights,
        private SellingRate $sellingRate,
        private Margin $margin
    ) {}

    public function nonProfit(): float
    {
        return (($this->sellingRate->value() * $this->margin->value() / 100) / $this->nights->value());
    }

}