<?php

declare(strict_types=1);

use Silvanei\BranasCleanArchitecture\Cpf;

test('Deve validar um cpf', function () {
    $cpf = new Cpf("935.411.347-80");
    expect($cpf->value)->toBe("93541134780");
});

test('Deve tentar criar um cpf inválido', function () {
    expect(fn() => new Cpf("123.456.789-99"))->toThrow(InvalidArgumentException::class, 'Invalid CPF');
});

test('Deve tentar criar um cpf com todos os digitos iguais', function () {
    expect(fn() => new Cpf("111.111.111-11"))->toThrow(InvalidArgumentException::class, 'Invalid CPF');
});

test('Deve tentar criar um cpf inválido muito grande', function () {
    expect(fn() => new Cpf("123.456.789-10000"))->toThrow(InvalidArgumentException::class, 'Invalid CPF');
});

test('Deve tentar criar um cpf inválido muito pequeno', function () {
    expect(fn() => new Cpf("123.456"))->toThrow(InvalidArgumentException::class, 'Invalid CPF');
});
