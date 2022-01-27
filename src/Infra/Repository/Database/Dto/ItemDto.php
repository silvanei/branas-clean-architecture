<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Repository\Database\Dto;

class ItemDto
{
    public function __construct(
        public readonly int $id_item,
        public readonly string $category,
        public readonly string $description,
        public readonly string $price,
        public readonly int $width,
        public readonly int $height,
        public readonly int $length,
        public readonly float $weight,
    ) {
    }
}
