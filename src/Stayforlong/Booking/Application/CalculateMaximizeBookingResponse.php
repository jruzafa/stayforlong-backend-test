<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Application;

final readonly class CalculateMaximizeBookingResponse
{
	public function __construct(
		private array $requestsIds,
		private float $totalProfit,
		private float $avgNight,
		private float $minNight,
		private float $maxNight
	) {}

	public function totalProfit(): float
	{
		return $this->totalProfit;
	}

	public function avgNight(): float
	{
		return $this->avgNight;
	}

	public function minNight(): float
	{
		return $this->minNight;
	}

	public function maxNight(): float
	{
		return $this->maxNight;
	}

	public function requestsIds(): array
	{
		return $this->requestsIds;
	}
}
