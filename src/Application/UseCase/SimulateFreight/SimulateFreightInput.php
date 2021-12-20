<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\UseCase\SimulateFreight;

final class SimulateFreightInput
{
    /**
     * @var SimulateFreightInputItem[]
     */
    public readonly array $items;

    public function __construct(SimulateFreightInputItem ...$items)
    {
        $this->items = $items;
    }
}
