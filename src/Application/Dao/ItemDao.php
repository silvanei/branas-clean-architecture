<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\Dao;

use Silvanei\BranasCleanArchitecture\Application\Query\PaginatorInput;
use Silvanei\BranasCleanArchitecture\Application\Query\PaginatorSequence;

interface ItemDao
{
    public function getItem(int $id): ?ItemDto;

    /**
     * @param PaginatorInput $paginatorInput
     * @return PaginatorSequence<ItemDto>
     */
    public function getItems(PaginatorInput $paginatorInput): PaginatorSequence;
}
