<?php

declare(strict_types=1);

namespace App\Tests\Unit\Stayforlong\Booking\Domain;

use Stayforlong\Booking\Domain\StatsResume;

final class StatsResumeMother
{
    public static function case1(): StatsResume
    {
        return new StatsResume(
            avg: 8.29,
            min: 8,
            max: 8.58
        );
    }

    public static function case2(): StatsResume
    {
        return new StatsResume(
            avg: 10.80,
            min: 10,
            max: 12.1
        );
    }
}