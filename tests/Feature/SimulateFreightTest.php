<?php

use Laminas\Diactoros\ServerRequest;

test('Deve simular o custo com frete', function () {
    $request = new ServerRequest(uri: "/simulate-freight", method: 'POST', parsedBody: [
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
