<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture;

final class OrderItem
{
    public function __construct(
        public readonly string $description,
        public readonly int|float $price,
        public readonly int $quantity,
    ) {
    }

    public function total(): int|float
    {
        return $this->price * $this->quantity;
    }
}
