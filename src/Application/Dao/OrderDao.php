<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\Dao;

interface OrderDao
{
    public function getOrder(string $code): ?OrderDto;

    /** @return OrderDto[] */
    public function getOrders(): array;

    /** @return ?OrderItemsDto[] */
    public function getOrderItems(string $code): ?array;
}
