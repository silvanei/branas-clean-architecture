<?php

namespace Silvanei\BranasCleanArchitecture\Domain\Repository;

use Silvanei\BranasCleanArchitecture\Domain\Entity\Order;

interface OrderRepository
{
    public function save(Order $order): void;
    public function count(): int;
    public function nextSequence(): int;
}
