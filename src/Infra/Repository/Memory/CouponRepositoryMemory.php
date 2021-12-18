<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Repository\Memory;

use Silvanei\BranasCleanArchitecture\Domain\Entity\Coupon;
use Silvanei\BranasCleanArchitecture\Domain\Repository\CouponRepository;

final class CouponRepositoryMemory implements CouponRepository
{
    /** @var Coupon[] */
    private array $coupons;

    public function __construct()
    {
        $this->coupons = [
            new Coupon('VALE20', 20),
        ];
    }

    public function findByCode(string $code): ?Coupon
    {
        foreach ($this->coupons as $coupon) {
            if ($coupon->code === $code) {
                return $coupon;
            }
        }
        return null;
    }
}
