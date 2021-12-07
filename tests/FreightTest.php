<?php

use Silvanei\BranasCleanArchitecture\Freight;
use Silvanei\BranasCleanArchitecture\Item;

test('Deve calcular o valor do frete com base nas dimensões e o peso dos produtos', function () {
    $freight = new Freight();
    $items = [
        new Item(1, 'Eletrônico', 'Camera', 1000, width: 20, height: 15, depth: 10, weight: 1),
        new Item(2, 'Eletrônico', 'Guitarra', 50, width: 100, height: 30, depth: 10, weight: 3),
        new Item(3, 'Eletrônico', 'Geladeira', 25, width: 200, height: 100, depth: 50, weight: 40),
    ];
    expect($freight->calculate(...$items))->toBe(439.99);
});

test('Deve retornar o preço mínimo do frete caso ele seja superior ao valor calculado', function () {
    $freight = new Freight();
    $items = [
        new Item(1, 'Eletrônico', 'Camera', 1000, width: 20, height: 15, depth: 10, weight: 1),
    ];
    expect($freight->calculate(...$items))->toBe(10);
});
