<?php

use Silvanei\BranasCleanArchitecture\Coupon;

test('Não deve aplicar desconto para cupom expirado', function () {
    $coupon = new Coupon('VALE10', 10, new DateTimeImmutable('2021-11-29T17:00:00'));
    expect($coupon->discount(100, new DateTimeImmutable('2021-11-30T17:00:00')))->toBe(100);
});

test('Deve aplicar desconto para cupom não expirado', function () {
    $coupon = new Coupon('VALE10', 10, new DateTimeImmutable('2021-11-30T17:00:00'));
    expect($coupon->discount(100, new DateTimeImmutable('2021-11-30T17:00:00')))->toBe(90);
});
