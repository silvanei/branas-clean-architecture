<?php

use Silvanei\BranasCleanArchitecture\Application\UseCase\ValidateCoupon\ValidateCoupon;
use Silvanei\BranasCleanArchitecture\Infra\Repository\Memory\CouponRepositoryMemory;

test('Deve validar um cupom de desconto', function () {
    $couponRepository = new CouponRepositoryMemory();
    $validateCoupon = new ValidateCoupon($couponRepository);
    $isValid = $validateCoupon->execute('VALE10');
    expect($isValid)->toBeTrue();
    $isValid = $validateCoupon->execute('VALE20');
    expect($isValid)->toBeFalse();
});
