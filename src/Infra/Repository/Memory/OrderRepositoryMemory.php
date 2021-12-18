<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Repository\Memory;

use Silvanei\BranasCleanArchitecture\Domain\Entity\Order;
use Silvanei\BranasCleanArchitecture\Domain\Repository\OrderRepository;

final class OrderRepositoryMemory implements OrderRepository
{
    /** @var Order[] */
    public array $orders = [];

    public function save(Order $order): void
    {
        $this->orders[] = $order;
    }
}
