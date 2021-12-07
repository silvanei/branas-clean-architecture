<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture;

use DateTimeImmutable;

final class Coupon
{
    public function __construct(
        public readonly string $code,
        private int $percentage,
        private DateTimeImmutable $expireDate = new DateTimeImmutable()
    ) {
    }

    public function discount(int|float $value, DateTimeImmutable $today = new DateTimeImmutable()): int|float
    {
        if ($this->expireDate >= $today) {
            return $value - (($value * $this->percentage) / 100);
        }
        return $value;
    }
}
