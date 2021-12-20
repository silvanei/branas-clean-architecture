<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\UseCase\ValidateCoupon;

use InvalidArgumentException;
use Silvanei\BranasCleanArchitecture\Domain\Repository\CouponRepository;

final class ValidateCoupon
{
    public function __construct(private CouponRepository $couponRepository)
    {
    }

    public function execute(string $code): bool
    {
        $coupon = $this->couponRepository->findByCode($code);
        if (! $coupon) {
            throw new InvalidArgumentException("Coupon not found");
        }
        return $coupon->isValid();
    }
}
