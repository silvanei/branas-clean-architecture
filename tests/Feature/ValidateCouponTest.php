<?php

use Laminas\Diactoros\ServerRequest;

test('Deve validar um cupom', function () {
    $request = new ServerRequest(uri: "/rest/v1/validate-coupon/VALE10", method: 'POST');
    $response = handle($request);
    expect($response->getStatusCode())->toBe(200);
    expect($response->getBody()->getContents())
        ->toBeJson()
        ->json()
        ->toBe([
            "code" => "VALE10",
            "isValid" => false,
        ]);
});

test('Deve retornar um 400 se um cupom não existir', function () {
    $request = new ServerRequest(uri: "/rest/v1/validate-coupon/VALE-NAO-EXISTE", method: 'POST');
    $response = handle($request);
    expect($response->getHeaderLine('content-type'))->toBe('application/problem+json');
    expect($response->getStatusCode())->toBe(400);
    expect($response->getBody()->getContents())
        ->toBeJson()
        ->json()
        ->toBe([
            "title" => "Bad request",
            "type" => "https://httpstatuses.com/400",
            "status" => 400,
            "detail" => "Coupon (VALE-NAO-EXISTE) not found"
        ]);
});
