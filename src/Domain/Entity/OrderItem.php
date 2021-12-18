<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Domain\Entity;

final class OrderItem
{
    public function __construct(
        public readonly int $idItem,
        private int|float $price,
        private int $quantity,
    ) {
    }

    public function total(): int|float
    {
        return $this->price * $this->quantity;
    }
}
