<?php declare(strict_types = 1);

namespace Stayforlong\Shared\Orm\Domain;

use ArrayIterator;
use Countable;
use IteratorAggregate;

abstract class Collection implements Countable, IteratorAggregate
{
    /** @var array */
    private $items;

    public function __construct(array $items)
    {
        $this->guard($items);
        $this->items = $items;
    }

    abstract protected function type(): string;

    public function getIterator()
    {
        return new ArrayIterator($this->items());
    }

    public function count()
    {
        return count($this->items());
    }

    protected function each(callable $fn)
    {
        each($fn, $this->items());
    }

    protected function items()
    {
        return $this->items;
    }

    private function guard(array $items): void
    {
        foreach ($items as $item) {
            if (get_class($item) !== $this->type()) {
                throw new \InvalidArgumentException('Item not instace from type class');
            }
        }
    }
}
