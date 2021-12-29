<?php

use Laminas\Diactoros\ServerRequest;

test('Deve validar um cupom', function () {
    $request = new ServerRequest(uri: "/validate-coupon/VALE10", method: 'POST');
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
