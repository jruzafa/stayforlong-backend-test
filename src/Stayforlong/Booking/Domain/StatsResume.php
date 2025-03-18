<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Domain;

final class StatsResume
{
    public function __construct(private float $avg, private float $min, private float $max) { }

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
}