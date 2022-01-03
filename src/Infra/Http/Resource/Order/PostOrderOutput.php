<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Http\Resource\Order;

final class PostOrderOutput
{
    public function __construct(public readonly string $code, public readonly float $total)
    {
    }
}
