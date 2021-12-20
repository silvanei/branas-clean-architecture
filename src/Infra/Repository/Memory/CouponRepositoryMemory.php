<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Repository\Memory;

use DateInterval;
use DateTimeImmutable;
use Silvanei\BranasCleanArchitecture\Domain\Entity\Coupon;
use Silvanei\BranasCleanArchitecture\Domain\Repository\CouponRepository;

final class CouponRepositoryMemory implements CouponRepository
{
    /** @var Coupon[] */
    private array $coupons;

    public function __construct()
    {
        $expiredCoupon = new Coupon('VALE20', 20, (new DateTimeImmutable())->sub(new DateInterval('P1D')));
        $notExpiredCoupon = new Coupon('VALE10', 10);
        $this->coupons = [
            $expiredCoupon,
            $notExpiredCoupon,
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
