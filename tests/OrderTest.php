<?php

declare(strict_types=1);

use Silvanei\BranasCleanArchitecture\Cpf;
use Silvanei\BranasCleanArchitecture\Coupon;
use Silvanei\BranasCleanArchitecture\Order;
use Silvanei\BranasCleanArchitecture\OrderItem;

test('Não deve criar um pedido com cpf inválido', function () {
    expect(fn() => new Order(new Cpf("123.456.789-99")))->toThrow(InvalidArgumentException::class, 'Invalid CPF');
});

test('Deve criar um pedido com 3 itens', function () {
    $order = new Order(new Cpf('935.411.347-80'));
    $order->add(new OrderItem('Item 1', 1000, 1));
    $order->add(new OrderItem('Item 2', 50, 2));
    $order->add(new OrderItem('Item 3', 25, 4));
    expect($order->total())->toBe(1200);
});

test('Deve criar um pedido com cupom de desconto', function () {
    $order = new Order(new Cpf('935.411.347-80'), new Coupon('AASSDI', 10));
    $order->add(new OrderItem('Item 1', 1000, 1));
    $order->add(new OrderItem('Item 2', 50, 2));
    $order->add(new OrderItem('Item 3', 25, 4));
    expect($order->total())->toBe(1080);
});
