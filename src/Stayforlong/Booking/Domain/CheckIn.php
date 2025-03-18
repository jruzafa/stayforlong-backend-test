<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Domain;

final class CheckIn extends \DateTimeImmutable
{
    public static function createFromString(string $value): CheckIn
    {
        $checkIn = new CheckIn($value);

        if ($checkIn < new \DateTimeImmutable()) {
            throw new \InvalidArgumentException('CheckIn date must be greater than today');
        }

        return $checkIn;
    }
}