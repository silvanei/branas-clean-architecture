<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Domain\Entity;

interface FreightCaculator
{
    public function calculate(Item $item): int|float;
}
