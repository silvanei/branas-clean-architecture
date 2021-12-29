<?php

use Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder\PlaceOrder;
use Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder\PlaceOrderInput;
use Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder\PlaceOrderInputItem;
use Silvanei\BranasCleanArchitecture\Domain\Repository\OrderRepository;

beforeEach(function () {
    $this->placeOrder = loadObject(PlaceOrder::class);
    $this->orderRepository = loadObject(OrderRepository::class);
});

afterEach(function () {
    $connection = loadObject(PDO::class);
    $connection->query('truncate table ccca.order_item restart identity');
    $connection->query('truncate table ccca.order restart identity');
    $connection->query("select setval('ccca.order_sequence', 1, false)");
});

test('Deve fazer uma pedido', function () {
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
    $output = $this->placeOrder->execute($placeOrderInput);
    expect($output->total)->toBe(2365.00);
});

test('Deve fazer uma pedido e validar o repository', function () {
    $placeOrderInput = new PlaceOrderInput(
        cpf: '935.411.347-80',
        orderItems: [
                 new PlaceOrderInputItem(...['idItem' => 1, 'quantity' => 1]),
             ],
        date: new DateTimeImmutable(),
        coupon: 'VALE20'
    );
    $this->placeOrder->execute($placeOrderInput);
    $this->placeOrder->execute($placeOrderInput);
    $this->placeOrder->execute($placeOrderInput);
    expect($this->orderRepository->count())->toBe(3);
});

test('Deve fazer uma pedido com cupom de desconto', function () {
    $placeOrderInput = new PlaceOrderInput(
        cpf: '935.411.347-80',
        orderItems: [
                 new PlaceOrderInputItem(idItem: 4, quantity: 1),
                 new PlaceOrderInputItem(idItem: 5, quantity: 1),
                 new PlaceOrderInputItem(idItem: 6, quantity: 3),
             ],
        date: new DateTimeImmutable('2021-12-01T00:00:00'),
        coupon: 'VALE10',
    );
    $output = $this->placeOrder->execute($placeOrderInput);
    expect($output->total)->toBe(5741.00);
});

test('Deve fazer uma pedido com frete', function () {
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
    $output = $this->placeOrder->execute($placeOrderInput);
    expect($output->total)->toBe(6350.00);
});

test('Deve fazer uma pedido com codigo', function () {
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
    $output = $this->placeOrder->execute($placeOrderInput);
    expect($output->code)->toBe('202100000001');
});
