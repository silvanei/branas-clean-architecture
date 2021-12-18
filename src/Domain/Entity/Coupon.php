<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Domain\Entity;

use DateTimeImmutable;

final class Coupon
{
    public function __construct(
        public readonly string $code,
        private int $percentage,
        private DateTimeImmutable $expireDate = new DateTimeImmutable()
    ) {
    }

    public function calculateDiscount(int|float $value, DateTimeImmutable $today = new DateTimeImmutable()): int|float
    {
        if ($this->isExpired($today)) {
            return 0;
        }
        return ($value * $this->percentage) / 100;
    }

    public function isExpired(DateTimeImmutable $today): bool
    {
        return $this->expireDate < $today;
    }
}
