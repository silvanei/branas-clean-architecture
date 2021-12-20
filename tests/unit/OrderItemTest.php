<?php

declare(strict_types=1);

use Decimal\Decimal;
use Silvanei\BranasCleanArchitecture\Domain\Entity\OrderItem;

test('Deve criar um pedido com cpf válido', function () {
    $orderItem = new OrderItem(1, new Decimal('1000.00'), 5);
    expect($orderItem->total())->toEqual(new Decimal('5000.00'));
});
