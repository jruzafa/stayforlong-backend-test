<?php declare(strict_types=1);

namespace Stayforlong\Shared\Types\Domain\Scalar;

use Webmozart\Assert\Assert;

abstract class StringValue
{
    private string $value;

    public function __construct(string $value)
    {
        $this->guard($value);
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(string $value): bool
    {
        return $value === $this->value;
    }

    public static function createFromString(string $value)
    {
        return new static($value);
    }

    public static function create(string $value)
    {
        return new static($value);
    }

    public static function random(): StringValue
    {
        return new static(static::randomValue());
    }

    public static function randomValue(): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randValue = '';

        for ($i = 0; $i < rand(5,10); $i++) {
            $range = rand(0, strlen($characters) - 1);
            $randValue .= $characters[$range];
        }

        return $randValue;
    }

    protected function guard(string $value): void
    {
        Assert::string($value);
    }
}
