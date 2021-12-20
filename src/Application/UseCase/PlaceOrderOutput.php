<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\UseCase;

final class PlaceOrderOutput
{
    public function __construct(public readonly string $code, public readonly int|float $total)
    {
    }
}
