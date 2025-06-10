<?php

declare(strict_types=1);

namespace Stayforlong\Shared\Types\Domain;

use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use Traversable;

abstract class Collection implements Countable, IteratorAggregate
{
	protected array $items;

	public function __construct(array $items)
	{
		$this->guard($items);
		$this->items = $items;
	}

	abstract protected function type(): string;

	public function getIterator(): Traversable
	{
		return new ArrayIterator($this->items());
	}

	public function count(): int
	{
		return count($this->items());
	}

	protected function items(): array
	{
		return $this->items;
	}

	private function guard(array $items): void
	{
		foreach ($items as $item) {
			if (get_class($item) !== $this->type()) {
				throw new InvalidArgumentException('Item not instance from type class');
			}
		}
	}

	public function toArray(): array
	{
		return $this->items;
	}
}
