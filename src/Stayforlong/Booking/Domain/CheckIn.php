<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Domain;

use DateMalformedStringException;
use DateTimeZone;

final class CheckIn extends \DateTimeImmutable
{
    public function __construct(
        string $datetime = "now",
        ?DateTimeZone $timezone = null)
    {
        $this->guard($datetime);

        parent::__construct($datetime, $timezone);
    }

    /**
     * @throws DateMalformedStringException
     */
    private function guard(string $datetime): void
    {
        $checkIn = new \DateTimeImmutable($datetime);

        if ($checkIn < new \DateTimeImmutable()) {
            throw new \InvalidArgumentException('CheckIn date must be greater than today');
        }
    }

    /**
     * @throws DateMalformedStringException
     */
    public static function createFromString(string $value): CheckIn
    {
        return new CheckIn($value);
    }
}