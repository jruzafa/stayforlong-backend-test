<?php

declare(strict_types=1);

namespace Stayforlong\Shared\Types\Domain\Scalar;

use Webmozart\Assert\Assert;

class IntegerValue
{
	private int $value;

	public function __construct(int $value)
	{
		$this->guard($value);
		$this->value = $value;
	}

	public static function createFromInt(int $value)
	{
        return new static($value);
	}

	public function value(): int
	{
		return $this->value;
	}

    protected function guard(int $value): void
	{
		Assert::integer($value, 'It\'s not integer value');
	}

	public static function random(): static
	{
        return new static(self::randomValue());
	}

	protected static function randomValue(): int
	{
		return rand(0, 9999);
	}

	public function __toString()
	{
		return (string) $this->value;
	}
}
