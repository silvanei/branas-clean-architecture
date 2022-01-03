<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\Query;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * @template TValue
 * @implements IteratorAggregate<int, TValue>
 * @phpstan-implements IteratorAggregate<int, TValue>
 *
 * @codeCoverageIgnore
 */
final class PaginatorSequence implements IteratorAggregate, Countable
{
    public function __construct(
        public readonly int $page = 1,
        public readonly int $itemCountPerPage = 100,
        public readonly int $totalItems = 0,
        /** @var array<TValue> $items */
        private array $items = []
    ) {
    }

    /**
     * @param callable $callback
     * @return PaginatorSequence
     *
     * @template TNewValue
     * @phpstan-param callable(TValue): TNewValue $callback
     * @phpstan-return PaginatorSequence<TNewValue>
     */
    public function map(callable $callback): PaginatorSequence
    {
        return new self($this->page, $this->itemCountPerPage, $this->totalItems, array_map($callback, $this->items));
    }

    /**
     * @return list<TValue>
     */
    public function toArray(): array
    {
        return $this->items;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }
}
