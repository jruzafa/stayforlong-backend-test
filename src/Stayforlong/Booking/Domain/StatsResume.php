<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Domain;

final readonly class StatsResume
{
	public function __construct(private float $avg, private float $min, private float $max) {}

	public function avg(): float
	{
		return $this->avg;
	}

	public function min(): float
	{
		return $this->min;
	}

	public function max(): float
	{
		return $this->max;
	}

	public static function empty(): self
	{
		return new self(0, 0, 0);
	}
}
