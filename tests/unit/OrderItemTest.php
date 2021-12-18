<?php

declare(strict_types=1);

use Silvanei\BranasCleanArchitecture\Domain\Entity\OrderItem;

test('Deve criar um pedido com cpf válido', function () {
    $orderItem = new OrderItem(1, 1000, 5);
    expect($orderItem->total())->toBe(5000);
});
