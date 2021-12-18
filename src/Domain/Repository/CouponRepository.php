<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Domain\Repository;

use Silvanei\BranasCleanArchitecture\Domain\Entity\Coupon;

interface CouponRepository
{
    public function findByCode(string $code): ?Coupon;
}
