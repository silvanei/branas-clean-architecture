<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Domain\Entity;

use Decimal\Decimal;

final class DefaultFreightCalculator implements FreightCaculator
{
    private int $distance = 1000;
    private int $minFreight = 10;

    public function calculate(Item $item): Decimal
    {
        $freight = $this->distance * $item->volume() * ($item->density() / 100);
        $maxFreight = max($freight, $this->minFreight);
        return new Decimal((string)$maxFreight);
    }
}
