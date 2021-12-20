<?php

use Decimal\Decimal;
use Silvanei\BranasCleanArchitecture\Domain\Entity\Item;

it('Deve calcular o volume e dencidade com base nas dimensões do produto', function (Item $item, int|float $volume, int|float $density) {
    expect($item->volume())->toBe($volume);
    expect($item->density())->toBe($density);
})->with(function () {
    yield [new Item(1, 'Eletrônico', 'Camera', new Decimal('1000.00'), width: 20, height: 15, depth: 10, weight: 1), 0.003, 333];
    yield [new Item(2, 'Eletrônico', 'Guitarra', new Decimal('50.00'), width: 100, height: 30, depth: 10, weight: 3), 0.03, 100];
    yield [new Item(3, 'Eletrônico', 'Geladeira', new Decimal('25.00'), width: 200, height: 100, depth: 50, weight: 40), 1, 40];
});
