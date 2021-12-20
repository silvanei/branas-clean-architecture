<?php

use Silvanei\BranasCleanArchitecture\Domain\Entity\OrderCode;

test('Deve gerar um código de pedido', function () {
    $orderCode = new OrderCode(date: new DateTimeImmutable('2021-12-20'), sequence: 1);
    expect($orderCode->value)->toBe('202100000001');
});
