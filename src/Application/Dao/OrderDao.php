<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\Dao;

use Silvanei\BranasCleanArchitecture\Application\Query\PaginatorInput;
use Silvanei\BranasCleanArchitecture\Application\Query\PaginatorSequence;

interface OrderDao
{
    public function getOrder(string $code): ?OrderDto;

    /** @return PaginatorSequence<OrderDto> */
    public function getOrders(PaginatorInput $paginatorInput): PaginatorSequence;

    /** @return ?OrderItemsDto[] */
    public function getOrderItems(string $code): ?array;
}
