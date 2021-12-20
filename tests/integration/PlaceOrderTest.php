<?php

use Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder\PlaceOrder;
use Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder\PlaceOrderInput;
use Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder\PlaceOrderInputItem;
use Silvanei\BranasCleanArchitecture\Infra\Repository\Memory\CouponRepositoryMemory;
use Silvanei\BranasCleanArchitecture\Infra\Repository\Memory\ItemRepositoryMemory;
use Silvanei\BranasCleanArchitecture\Infra\Repository\Memory\OrderRepositoryMemory;

test('Deve fazer uma pedido', function () {
    $itemRepository = new ItemRepositoryMemory();
    $couponRepository = new CouponRepositoryMemory();
    $orderRepository = new OrderRepositoryMemory();
    $placeOrder = new PlaceOrder($itemRepository, $couponRepository, $orderRepository);
    $placeOrderInput = new PlaceOrderInput(
        cpf: '935.411.347-80',
        orderItems: [
            new PlaceOrderInputItem(...['idItem' => 1, 'quantity' => 1]),
            new PlaceOrderInputItem(...['idItem' => 2, 'quantity' => 1]),
            new PlaceOrderInputItem(...['idItem' => 3, 'quantity' => 3]),
        ],
        date: new DateTimeImmutable(),
        coupon: 'VALE20'
    );
    $output = $placeOrder->execute($placeOrderInput);
    expect($output->total)->toBe(2365.0);
});

test('Deve fazer uma pedido com frete', function () {
    $itemRepository = new ItemRepositoryMemory();
    $couponRepository = new CouponRepositoryMemory();
    $orderRepository = new OrderRepositoryMemory();
    $placeOrder = new PlaceOrder($itemRepository, $couponRepository, $orderRepository);
    $placeOrderInput = new PlaceOrderInput(
        cpf: '935.411.347-80',
        orderItems: [
            new PlaceOrderInputItem(idItem: 4, quantity: 1),
            new PlaceOrderInputItem(idItem: 5, quantity: 1),
            new PlaceOrderInputItem(idItem: 6, quantity: 3),
        ],
        date: new DateTimeImmutable(),
        coupon: 'VALE20',
    );
    $output = $placeOrder->execute($placeOrderInput);
    expect($output->total)->toBe(6350.0);
});

test('Deve fazer uma pedido com codigo', function () {
    $itemRepository = new ItemRepositoryMemory();
    $couponRepository = new CouponRepositoryMemory();
    $orderRepository = new OrderRepositoryMemory();
    $placeOrder = new PlaceOrder($itemRepository, $couponRepository, $orderRepository);
    $placeOrderInput = new PlaceOrderInput(
        cpf: '935.411.347-80',
        orderItems: [
                 new PlaceOrderInputItem(idItem: 4, quantity: 1),
                 new PlaceOrderInputItem(idItem: 5, quantity: 1),
                 new PlaceOrderInputItem(idItem: 6, quantity: 3),
             ],
        date: new DateTimeImmutable('2021-12-20'),
        coupon: 'VALE20',
    );
    $output = $placeOrder->execute($placeOrderInput);
    expect($output->code)->toBe('202100000001');
});
