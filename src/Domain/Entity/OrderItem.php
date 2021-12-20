<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Domain\Entity;

use Decimal\Decimal;

final class OrderItem
{
    public function __construct(
        public readonly int $idItem,
        private Decimal $price,
        private int $quantity,
    ) {
    }

    public function total(): Decimal
    {
        return $this->price->mul($this->quantity);
    }
}
