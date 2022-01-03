<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Http\Resource;

use Laminas\Paginator\Adapter\AdapterInterface;
use Silvanei\BranasCleanArchitecture\Application\Query\PaginatorSequence;

/**
 * @template TValue
 *
 * @codeCoverageIgnore
 */
final class PaginatorSequenceAdapter implements AdapterInterface
{
    /**
     * @param PaginatorSequence<TValue> $sequence
     */
    public function __construct(protected PaginatorSequence $sequence)
    {
    }

    /**
     * @param int $offset
     * @param int $itemCountPerPage
     * @return iterable<TValue>
     */
    public function getItems($offset, $itemCountPerPage): iterable
    {
        return $this->sequence->toArray();
    }

    public function count(): int
    {
        return $this->sequence->totalItems;
    }
}
