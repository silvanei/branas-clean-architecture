<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Domain\Entity;

final class DefaultFreightCalculator implements FreightCaculator
{
    private int $distance = 1000;
    private int $minFreight = 10;

    public function calculate(Item $item): int|float
    {
        $freight = $this->distance * $item->volume() * ($item->density() / 100);
        return max($freight, $this->minFreight);
    }
}
