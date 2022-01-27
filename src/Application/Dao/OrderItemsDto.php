<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\Dao;

class OrderItemsDto
{
    public function __construct(
        public readonly string $category,
        public readonly string $description,
        public readonly float $price,
    ) {
    }
}
