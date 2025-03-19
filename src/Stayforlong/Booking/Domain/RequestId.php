<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Domain;

use Stayforlong\Shared\Types\Domain\Scalar\StringValue;

final class RequestId extends StringValue
{
    protected function guard(string $value): void
    {
        parent::guard($value);

        if (!preg_match('/^[^_]+_[A-Za-z0-9]+$/', $value)) {
            throw new \InvalidArgumentException('Invalid request id: ' . $value);
        }
    }

    public static function randomValue(): string
    {
        $letters = 'abcdefghijklmnopqrstuvwxyz';
        $prefix = '';
        $max = strlen($letters) - 1;

        for ($i = 0; $i < rand(5, 10); $i++) {
            $prefix .= $letters[rand(0, $max)];
        }

        $letters = mb_strtoupper($letters);

        $firstSuffix = $letters[rand(0, $max)] . $letters[rand(0, $max)];

        $qty = rand(2, 3);
        $suffix = '';

        for ($i = 0; $i < $qty; $i++) {
            $suffix .= rand(0, 9);
        }

        $suffix .= $firstSuffix;

        return $prefix . '_' .  $suffix;
    }

    public function equals(RequestId $requestId): bool
    {
        return $this->value() === $requestId->value();
    }
}