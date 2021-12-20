<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Domain\Entity;

use DateTimeImmutable;
use Decimal\Decimal;

final class Coupon
{
    public function __construct(
        public readonly string $code,
        private int $percentage,
        private DateTimeImmutable $expireDate = new DateTimeImmutable()
    ) {
    }

    public function calculateDiscount(Decimal $value, DateTimeImmutable $today = new DateTimeImmutable()): Decimal
    {
        if ($this->isExpired($today)) {
            return new Decimal(0);
        }
        return $value->mul($this->percentage)->div(100);
    }

    public function isExpired(DateTimeImmutable $today): bool
    {
        return $this->expireDate < $today;
    }
}
