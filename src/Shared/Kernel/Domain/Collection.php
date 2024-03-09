<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Domain;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use Traversable;
use function call_user_func;


abstract class Collection implements Countable, JsonSerializable, IteratorAggregate
{

    protected array $items = [];

    protected function __construct(array $items)
    {
        $this->items = array_values($items);
    }

    protected function find(callable $callback): mixed
    {
        foreach ($this->items as $item) {
            if (call_user_func($callback, $item)) {
                return $item;
            }
        }

        return null;
    }

    protected function remove(callable $callback): bool
    {
        foreach ($this->items as $key => $item) {
            if (call_user_func($callback, $item)) {
                unset($this->items[$key]);
                $this->items = array_values($this->items);
                return true;
            }
        }
        return false;
    }

    protected function search(callable $callback): array
    {
        $items = [];
        foreach ($this->items as $item) {
            if (call_user_func($callback, $item)) {
                $items[] = $item;
            }
        }

        return $items;
    }

    protected function contains(callable $callback): bool
    {
        return null !== $this->find($callback);
    }

    public function map(callable $callback): array
    {
        $items = array_map($callback, $this->items);

        return $items;
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function toArray(): array
    {
        return $this->items;
    }

    public function first(): mixed
    {
        return $this->items[0] ?? null;
    }

    public function last(): mixed
    {
        $lastPosition = count($this->items) - 1;
        return $this->items[$lastPosition] ?? null;
    }

    public function current(): mixed
    {
        return current($this->items);
    }

    public function jsonSerialize(): array
    {
        return $this->items;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
