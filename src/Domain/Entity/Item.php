<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Domain\Entity;

use Decimal\Decimal;

final class Item
{
    public function __construct(
        public readonly int $id,
        public readonly string $category,
        public readonly string $description,
        public readonly Decimal $price,
        public readonly int $width,
        public readonly int $height,
        public readonly int $depth,
        public readonly int|float $weight,
    ) {
    }

    public function volume(): int|float
    {
        return ($this->width / 100 * $this->height / 100 * $this->depth / 100);
    }

    public function density(): int
    {
        return (int)($this->weight / $this->volume());
    }
}
