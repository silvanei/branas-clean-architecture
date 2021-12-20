<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Domain\Entity;

use Decimal\Decimal;

interface FreightCaculator
{
    public function calculate(Item $item): Decimal;
}
