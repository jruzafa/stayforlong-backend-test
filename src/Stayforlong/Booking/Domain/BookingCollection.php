<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Domain;

use Stayforlong\Shared\Types\Domain\Collection;

final class BookingCollection extends Collection
{
    public function add(Booking $request): void
    {
        $this->items[$request->id()->value()] = $request;
    }

    protected function type(): string
    {
        return Booking::class;
    }

    public function findById(RequestId $requestId): ?Booking
    {
        return $this->items[$requestId->value()] ?? null;
    }

    public function toArray(): array
    {
        return array_values($this->items);
    }
}