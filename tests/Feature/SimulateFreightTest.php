<?php

use Laminas\Diactoros\ServerRequest;

test('Deve simular o custo com frete', function () {
    $request = new ServerRequest(uri: "/rest/v1/simulate-freight", method: 'POST', parsedBody: [
        ["idItem" => 4, "quantity" => 1],
        ["idItem" => 5, "quantity" => 1],
        ["idItem" => 6, "quantity" => 3],
    ]);
    $response = handle($request);
    expect($response->getStatusCode())->toBe(200);
    expect($response->getBody()->getContents())
        ->toBeJson()
        ->json()
        ->toBe(["amount" => 260]);
});

test('Deve retornar um 400 se um item não existir', function () {
    $request = new ServerRequest(uri: "/rest/v1/simulate-freight", method: 'POST', parsedBody: [
        ["idItem" => 400000, "quantity" => 1]
    ]);
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
            "detail" => "Item (400000) not found"
        ]);
});
