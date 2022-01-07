<?php

use Silvanei\BranasCleanArchitecture\Application\Query\Item\GetItemOutput;
use Silvanei\BranasCleanArchitecture\Application\Query\Item\GetItems;
use Silvanei\BranasCleanArchitecture\Application\Query\PaginatorInput;

test('Deve retornar uma lista de itens', function () {
    $getItems = loadObject(GetItems::class);
    $result = $getItems->execute(new PaginatorInput(page: 2, itemCountPerPage: 2));
    expect($result->page)->toBe(2);
    expect($result->itemCountPerPage)->toBe(2);
    expect($result->totalItems)->toBe(6);
    expect($result)
        ->toHaveLength(2)
        ->each(fn($item) => $item->toBeInstanceOf(GetItemOutput::class));
});
