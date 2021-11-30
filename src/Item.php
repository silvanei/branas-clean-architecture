<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture;

final class Item
{
    public function __construct(
        public readonly int $id,
        public readonly string $category,
        public readonly string $description,
        public readonly int|float $price,
    ) {
    }
}
