<?php

use Silvanei\BranasCleanArchitecture\Application\Dao\OrderItemsDto;
use Silvanei\BranasCleanArchitecture\Application\Query\Order\GetOrder;
use Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder\PlaceOrder;
use Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder\PlaceOrderInput;
use Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder\PlaceOrderInputItem;

beforeEach(function () {
    $this->placeOrder = loadObject(PlaceOrder::class);
    $this->getOrder = loadObject(GetOrder::class);
});

afterEach(function () {
    clearOrder();
});

test('Deve retornar um item pelo id', function () {
    $placeOrderInput = new PlaceOrderInput(
        cpf: '935.411.347-80',
        orderItems: [
                 new PlaceOrderInputItem(...['idItem' => 4, 'quantity' => 1]),
                 new PlaceOrderInputItem(...['idItem' => 5, 'quantity' => 1]),
                 new PlaceOrderInputItem(...['idItem' => 6, 'quantity' => 3]),
             ],
        date: new DateTimeImmutable('2021-12-01T00:00:00'),
        coupon: 'VALE20'
    );
    $this->placeOrder->execute($placeOrderInput);
    $getOrderOutput = $this->getOrder->execute('202100000001');
    expect($getOrderOutput->id)->toBe(1);
    expect($getOrderOutput->code)->toBe('202100000001');
    expect($getOrderOutput->cpf)->toBe('93541134780');
    expect($getOrderOutput->freight)->toBe(260.00);
    expect($getOrderOutput->orderItems)
        ->toHaveLength(3)
        ->each(fn($item) => $item->toBeInstanceOf(OrderItemsDto::class));
});

test('Deve retornar um null para um id invalido', function () {
    $getOrderOutput = $this->getOrder->execute('202100000001');
    expect($getOrderOutput)->toBeNull();
});
