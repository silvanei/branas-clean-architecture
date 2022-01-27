<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\Dao;

final class ItemDto
{
    public function __construct(
        public int $id,
        public string $category,
        public string $description,
        public float $price,
    ) {
    }
}
