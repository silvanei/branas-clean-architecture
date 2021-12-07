<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture;

interface FreightCaculator
{
    public function calculate(Item $item): int|float;
}
