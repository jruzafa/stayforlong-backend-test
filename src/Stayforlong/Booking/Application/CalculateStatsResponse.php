<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Application;

final readonly class CalculateStatsResponse
{
    public function __construct(private float $avgNight, private float $minNight, private float $maxNight) { }

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
}