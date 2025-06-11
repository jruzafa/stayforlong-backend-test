<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Infrastructure;

final readonly class MaximizeStatsPresenter
{
	public function __construct(private array $bookingRequestIds, private float $totalProfit) {}

	public function toArray(): array
	{
		return [
			'request_ids'  => $this->bookingRequestIds,
			'total_profit' => $this->totalProfit,
		];
	}
}
