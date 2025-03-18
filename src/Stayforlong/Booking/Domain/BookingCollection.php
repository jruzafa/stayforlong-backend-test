<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Domain;

use Stayforlong\Shared\Orm\Domain\Collection;

final class BookingCollection extends Collection
{
    public function add(Booking $request): void
    {
        $this->items[] = $request;
    }

    protected function type(): string
    {
        return Booking::class;
    }
}