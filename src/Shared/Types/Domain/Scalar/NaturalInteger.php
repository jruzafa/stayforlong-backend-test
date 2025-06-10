<?php

declare(strict_types=1);

namespace Stayforlong\Shared\Types\Domain\Scalar;

use Webmozart\Assert\Assert;

class NaturalInteger extends IntegerValue
{
	public static function createFromInt(int $value)
	{
		return new static($value);
	}

	public static function random(): static
	{
        return new static(static::randomValue());
	}

	protected function guard(int $value): void
	{
		Assert::greaterThan($value, 0);
	}
}
