<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\Query\Item;

class GetItemOutput
{
    public function __construct(
        public readonly int $id,
        public string $category,
        public string $description,
        public float $price,
    ) {
    }
}
