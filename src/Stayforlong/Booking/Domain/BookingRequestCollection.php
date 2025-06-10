<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Domain;

use Stayforlong\Shared\Types\Domain\Collection;

final class BookingRequestCollection extends Collection
{
	public function add(BookingRequest $request): void
	{
		$this->items[$request->id()->value()] = $request;
	}

	public function isEmpty(): bool
	{
		return $this->count() === 0;
	}

	protected function type(): string
	{
		return BookingRequest::class;
	}

	public function findById(RequestId $requestId): ?BookingRequest
	{
		return $this->items[$requestId->value()] ?? null;
	}

	public function toArray(): array
	{
		return array_values($this->items);
	}
}
