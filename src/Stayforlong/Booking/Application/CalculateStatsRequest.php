<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Application;

final class CalculateStatsRequest
{
    public function __construct(private array $data) {
    }

    public function data(): array
    {
        return $this->data;
    }
}