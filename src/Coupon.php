<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture;

final class Coupon
{

    public function __construct(public readonly string $code, private int $discount)
    {
    }

    public function discount(int|float $total): int|float
    {
        return $total - (($total * $this->discount) / 100);
    }
}
