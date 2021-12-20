<?php

use Decimal\Decimal;
use Silvanei\BranasCleanArchitecture\Domain\Entity\DefaultFreightCalculator;
use Silvanei\BranasCleanArchitecture\Domain\Entity\Item;

test('Deve calcular o valor do frete com base nas dimensões e o peso dos produtos', function () {
    $freight = new DefaultFreightCalculator();
    $item = new Item(3, 'Eletrônico', 'Geladeira', new Decimal('25.00'), width: 200, height: 100, depth: 50, weight: 40);
    $amount = $freight->calculate($item);
    expect($amount->toFloat())->toBe(400.00);
});

test('Deve retornar o preço mínimo do frete caso ele seja superior ao valor calculado', function () {
    $freight = new DefaultFreightCalculator();
    $item = new Item(1, 'Eletrônico', 'Camera', new Decimal('1000.00'), width: 20, height: 15, depth: 10, weight: 1);
    $amount = $freight->calculate($item);
    expect($amount->toFloat())->toBe(10.00);
});
