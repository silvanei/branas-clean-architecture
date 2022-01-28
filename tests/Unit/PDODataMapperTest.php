<?php

use Silvanei\BranasCleanArchitecture\Infra\Database\PDODataMapper;
use Tests\Silvanei\BranasCleanArchitecture\Unit\PDODataMapperDto;

test('Deve mapear um array para uma classe', function () {
    $dataMapper = new PDODataMapper();
    $classDto = $dataMapper->map(PDODataMapperDto::class, ['id' => 1, 'name' => 'Teste', 'price' => 1.01]);
    expect($classDto)->toBeInstanceOf(PDODataMapperDto::class);
    expect($classDto->id)->toBeInt()->toBe(1);
    expect($classDto->name)->toBeString()->toBe('Teste');
    expect($classDto->price)->toBeFloat()->toBe(1.01);
});

test('Deve mapear uma lista de array para uma classe', function () {
    $dataMapper = new PDODataMapper();
    $classDtoList = $dataMapper->arrayMap(PDODataMapperDto::class, [
        ['id' => 1, 'name' => 'Teste 1', 'price' => 1.01],
        ['id' => 2, 'name' => 'Teste 2', 'price' => 2.01],
        ['id' => 3, 'name' => 'Teste 3', 'price' => 3.01],
    ]);
    expect($classDtoList)
        ->toBeArray()
        ->toHaveLength(3)
    ;
});
