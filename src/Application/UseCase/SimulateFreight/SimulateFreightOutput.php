<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\UseCase\SimulateFreight;

final class SimulateFreightOutput
{
    public function __construct(public readonly float $amount)
    {
    }
}
