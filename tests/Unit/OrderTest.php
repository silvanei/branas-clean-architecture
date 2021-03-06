<?php

declare(strict_types=1);

use Decimal\Decimal;
use Silvanei\BranasCleanArchitecture\Domain\Entity\Coupon;
use Silvanei\BranasCleanArchitecture\Domain\Entity\Cpf;
use Silvanei\BranasCleanArchitecture\Domain\Entity\Item;
use Silvanei\BranasCleanArchitecture\Domain\Entity\Order;

test('Deve criar um pedido com cpf válido', function () {
    $order = new Order(new Cpf('935.411.347-80'), new DateTimeImmutable('2021-11-30T00:00:00'));
    $total = $order->total();
    expect($total->toFloat())->toBe(0.00);
});

test('Não deve criar um pedido com cpf inválido', function () {
    expect(
        fn() => new Order(new Cpf("123.456.789-99"), new DateTimeImmutable('2021-11-30T00:00:00'))
    )->toThrow(InvalidArgumentException::class, 'Invalid CPF');
});

test('Deve criar um pedido com 3 itens', function () {
    $order = new Order(new Cpf('935.411.347-80'), new DateTimeImmutable('2021-11-30T00:00:00'));
    $order->add(new Item(1, 'Categoria 1', 'Descrição 1', new Decimal('1000.00'), 20, 15, 10, 1), 1);
    $order->add(new Item(2, 'Categoria 2', 'Descrição 2', new Decimal('50.00'), 100, 30, 10, 3), 2);
    $order->add(new Item(3, 'Categoria 3', 'Descrição 3', new Decimal('25.00'), 200, 100, 50, 40), 4);
    $total = $order->total();
    expect($total->toFloat())->toBe(2870.00);
});

test('Deve criar um pedido com cupom de desconto', function () {
    $order = new Order(new Cpf('935.411.347-80'), new DateTimeImmutable('2021-11-30T00:00:00'));
    $order->add(new Item(1, 'Categoria 1', 'Descrição 1', new Decimal('1000.00'), 20, 15, 10, 1), 1);
    $order->add(new Item(2, 'Categoria 2', 'Descrição 2', new Decimal('50.00'), 100, 30, 10, 3), 2);
    $order->add(new Item(3, 'Categoria 3', 'Descrição 3', new Decimal('25.00'), 200, 100, 50, 40), 4);
    $order->addCoupon(new Coupon('VALE10', 10));
    $total = $order->total();
    expect($total->toFloat())->toBe(2750.00);
});

test('Não deve aplicar desconto para cupom expirado', function () {
    $order = new Order(new Cpf('935.411.347-80'), new DateTimeImmutable('2021-11-30T00:00:00'));
    $order->add(new Item(1, 'Categoria 1', 'Descrição 1', new Decimal('1000.00'), 20, 15, 10, 1), 1);
    $order->add(new Item(2, 'Categoria 2', 'Descrição 2', new Decimal('50.00'), 100, 30, 10, 3), 2);
    $order->add(new Item(3, 'Categoria 3', 'Descrição 3', new Decimal('25.00'), 200, 100, 50, 40), 4);
    $order->addCoupon(new Coupon('VALE10', 10, new DateTimeImmutable('2021-11-29T00:00:00')));
    $total = $order->total();
    expect($total->toFloat())->toBe(2870.00);
});

test("Deve criar um pedido com 3 itens com o cálculo do frete com a estratégia default", function () {
    $order = new Order(new Cpf('935.411.347-80'), new DateTimeImmutable('2021-11-30T00:00:00'));
    $order->add(new Item(1, "Instrumentos Musicais", "Guitarra", new Decimal('1000.00'), 100, 30, 10, 3), 1);
    $order->add(new Item(2, "Instrumentos Musicais", "Amplificador", new Decimal('5000.00'), 100, 50, 50, 20), 1);
    $order->add(new Item(3, "Acessórios", "Cabo", new Decimal('30.00'), 10, 10, 10, 0.9), 3);
    $freight = $order->freight();
    expect($freight->toFloat())->toBe(260.00);
});

test("Deve criar um pedido com código", function () {
    $order = new Order(new Cpf('935.411.347-80'), new DateTimeImmutable('2021-11-30T00:00:00'));
    $order->add(new Item(1, "Instrumentos Musicais", "Guitarra", new Decimal('1000.00'), 100, 30, 10, 3), 1);
    $order->add(new Item(2, "Instrumentos Musicais", "Amplificador", new Decimal('5000.00'), 100, 50, 50, 20), 1);
    $order->add(new Item(3, "Acessórios", "Cabo", new Decimal('30.00'), 10, 10, 10, 0.9), 3);
    expect($order->code())->toBe('202100000001');
});
