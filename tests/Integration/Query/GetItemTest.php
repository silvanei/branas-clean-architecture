<?php

use Silvanei\BranasCleanArchitecture\Application\Query\Item\GetItem;

beforeEach(function () {
    $this->getItem = loadObject(GetItem::class);
});

test('Deve retornar um item pelo id', function () {
    $result = $this->getItem->execute(1);
    expect($result?->id)->toBe(1);
    expect($result?->category)->toBe('Música');
    expect($result?->description)->toBe('CD');
    expect($result?->price)->toBe(1000.00);
});

test('Deve retornar um null para um id invalido', function () {
    $result = $this->getItem->execute(0);
    expect($result)->toBeNull();
});
