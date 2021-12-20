<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\UseCase\SimulateFreight;

final class SimulateFreightInputItem
{
    public function __construct(public readonly int $idItem, public readonly int $quantity)
    {
    }
}
