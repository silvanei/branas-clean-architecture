<?php

use Silvanei\BranasCleanArchitecture\Application\Query\Order\GetOrderOutput;
use Silvanei\BranasCleanArchitecture\Application\Query\Order\GetOrders;
use Silvanei\BranasCleanArchitecture\Application\Query\PaginatorInput;
use Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder\PlaceOrder;
use Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder\PlaceOrderInput;
use Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder\PlaceOrderInputItem;

beforeEach(function () {
    $this->placeOrder = loadObject(PlaceOrder::class);
    $this->getOrders = loadObject(GetOrders::class);
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
    $this->placeOrder->execute($placeOrderInput);
    $this->placeOrder->execute($placeOrderInput);
    $this->placeOrder->execute($placeOrderInput);
    $paginatorSequence = $this->getOrders->execute(new PaginatorInput(page: 2, itemCountPerPage: 2));
    expect($paginatorSequence->page)->toBe(2);
    expect($paginatorSequence->itemCountPerPage)->toBe(2);
    expect($paginatorSequence->totalItems)->toBe(4);
    expect($paginatorSequence)
        ->toHaveLength(2)
        ->each(fn($order) => $order->toBeInstanceOf(GetOrderOutput::class));
});
