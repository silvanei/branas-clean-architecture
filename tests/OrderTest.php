<?php

declare(strict_types=1);

use Silvanei\BranasCleanArchitecture\Coupon;
use Silvanei\BranasCleanArchitecture\Cpf;
use Silvanei\BranasCleanArchitecture\Item;
use Silvanei\BranasCleanArchitecture\Order;

test('Deve criar um pedido com cpf válido', function () {
    $order = new Order(new Cpf('935.411.347-80'), new DateTimeImmutable('2021-11-30T00:00:00'));
    expect($order->total())->toBe(0);
});

test('Não deve criar um pedido com cpf inválido', function () {
    expect(
        fn() => new Order(new Cpf("123.456.789-99"), new DateTimeImmutable('2021-11-30T00:00:00'))
    )->toThrow(InvalidArgumentException::class, 'Invalid CPF');
});

test('Deve criar um pedido com 3 itens', function () {
    $order = new Order(new Cpf('935.411.347-80'), new DateTimeImmutable('2021-11-30T00:00:00'));
    $order->add(new Item(1, 'Categoria 1', 'Descrição 1', 1000, 20, 15, 10, 1), 1);
    $order->add(new Item(2, 'Categoria 2', 'Descrição 2', 50, 100, 30, 10, 3), 2);
    $order->add(new Item(3, 'Categoria 3', 'Descrição 3', 25, 200, 100, 50, 40), 4);
    expect($order->total())->toBe(1200);
});

test('Deve criar um pedido com cupom de desconto', function () {
    $order = new Order(new Cpf('935.411.347-80'), new DateTimeImmutable('2021-11-30T00:00:00'));
    $order->add(new Item(1, 'Categoria 1', 'Descrição 1', 1000, 20, 15, 10, 1), 1);
    $order->add(new Item(2, 'Categoria 2', 'Descrição 2', 50, 100, 30, 10, 3), 2);
    $order->add(new Item(3, 'Categoria 3', 'Descrição 3', 25, 200, 100, 50, 40), 4);
    $order->addCoupon(new Coupon('VALE10', 10));
    expect($order->total())->toBe(1080);
});

test('Não deve aplicar desconto para cupom expirado', function () {
    $order = new Order(new Cpf('935.411.347-80'), new DateTimeImmutable('2021-11-30T00:00:00'));
    $order->add(new Item(1, 'Categoria 1', 'Descrição 1', 1000, 20, 15, 10, 1), 1);
    $order->add(new Item(2, 'Categoria 2', 'Descrição 2', 50, 100, 30, 10, 3), 2);
    $order->add(new Item(3, 'Categoria 3', 'Descrição 3', 25, 200, 100, 50, 40), 4);
    $order->addCoupon(new Coupon('VALE10', 10, new DateTimeImmutable('2021-11-29T00:00:00')));
    expect($order->total())->toBe(1200);
});
