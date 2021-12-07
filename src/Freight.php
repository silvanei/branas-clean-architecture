<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture;

final class Freight
{
    public function __construct(private int $distance = 1000, private int|float $minFreight = 10)
    {
    }

    public function calculate(Item ...$items): int|float
    {
        $freight = array_reduce(
            array: $items,
            callback: fn($value, Item $item) => $value + ($this->distance * $item->volume() * ($item->density() / 100)),
            initial: 0.0
        );
        return max($freight, $this->minFreight);
    }
}
