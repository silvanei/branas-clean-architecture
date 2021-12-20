<?php

use Decimal\Decimal;
use Silvanei\BranasCleanArchitecture\Domain\Entity\Coupon;

test('Não deve aplicar desconto para cupom expirado', function () {
    $coupon = new Coupon('VALE10', 10, new DateTimeImmutable('2021-11-30T16:00:00'));
    expect($coupon->calculateDiscount(new Decimal('100.00'), new DateTimeImmutable('2021-11-30T17:00:00')))->toEqual(new Decimal(0));
});

test('Deve aplicar desconto para cupom não expirado com a data de expiração igual a data de verificação', function () {
    $coupon = new Coupon('VALE10', 10, new DateTimeImmutable('2021-11-30T17:00:00'));
    expect($coupon->calculateDiscount(new Decimal('100.00'), new DateTimeImmutable('2021-11-30T17:00:00')))->toEqual(new Decimal('10.00'));
});

test('Deve aplicar desconto para cupom não expirado com a data de expiração mior que data de verificação', function () {
    $coupon = new Coupon('VALE10', 10, new DateTimeImmutable('2021-11-30T17:00:01'));
    expect($coupon->calculateDiscount(new Decimal('100.00'), new DateTimeImmutable('2021-11-30T17:00:00')))->toEqual(new Decimal('10.00'));
});
