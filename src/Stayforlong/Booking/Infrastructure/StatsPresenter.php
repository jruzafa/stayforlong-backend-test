<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Infrastructure;

final readonly class StatsPresenter
{
    public function __construct(private float $avgNight, private float $minNight, private float $maxNight) { }

    public function toArray(): array
    {
        return [
            'avg_night' => $this->avgNight,
            'min_night' => $this->minNight,
            'max_night' => $this->maxNight
        ];
    }

}