<?php

declare(strict_types=1);

use Silvanei\BranasCleanArchitecture\Domain\Entity\Cpf;

test('Deve validar um cpf', function () {
    $cpf = new Cpf("935.411.347-80");
    expect($cpf->value)->toBe("93541134780");
});

test('Deve validar um cpf com digito verificador 00', function () {
    $cpf = new Cpf("987.654.321-00");
    expect($cpf->value)->toBe("98765432100");
});

test('Deve validar um cpf com digito verificador 29', function () {
    $cpf = new Cpf("828.946.610-29");
    expect($cpf->value)->toBe("82894661029");
});

test('Deve validar um cpf com digito verificador 82', function () {
    $cpf = new Cpf("489.643.290-82");
    expect($cpf->value)->toBe("48964329082");
});

test('Deve tentar criar um cpf inválido com letras', function () {
    expect(fn() => new Cpf("123a456b789c99"))->toThrow(InvalidArgumentException::class, 'Invalid CPF');
});

test('Deve tentar criar um cpf inválido', function () {
    expect(fn() => new Cpf("123.456.789-99"))->toThrow(InvalidArgumentException::class, 'Invalid CPF');
});

test('Deve tentar criar um cpf com todos os digitos iguais', function () {
    expect(fn() => new Cpf("111.111.111-11"))->toThrow(InvalidArgumentException::class, 'Invalid CPF');
});

test('Deve tentar criar um cpf inválido muito grande', function () {
    expect(fn() => new Cpf("123.456.789-10000"))->toThrow(InvalidArgumentException::class, 'Invalid CPF length');
});

test('Deve tentar criar um cpf inválido muito pequeno', function () {
    expect(fn() => new Cpf("123.456"))->toThrow(InvalidArgumentException::class, 'Invalid CPF length');
});
