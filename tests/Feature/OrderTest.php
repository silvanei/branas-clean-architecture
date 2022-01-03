<?php

use Laminas\Diactoros\ServerRequest;
use Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder\PlaceOrder;
use Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder\PlaceOrderInput;
use Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder\PlaceOrderInputItem;

beforeEach(function () {
    $this->placeOrder = loadObject(PlaceOrder::class);
});

afterEach(function () {
    $connection = loadObject(PDO::class);
    $connection->query('truncate table ccca.order_item restart identity');
    $connection->query('truncate table ccca.order restart identity');
    $connection->query("select setval('ccca.order_sequence', 1, false)");
});

test('Deve retornar um pedido pelo código', function () {
    $placeOrderInput = new PlaceOrderInput(
        cpf:        '935.411.347-80',
        orderItems: [
            new PlaceOrderInputItem(...['idItem' => 1, 'quantity' => 1]),
            new PlaceOrderInputItem(...['idItem' => 2, 'quantity' => 1]),
            new PlaceOrderInputItem(...['idItem' => 3, 'quantity' => 3]),
        ],
        date:       new DateTimeImmutable(),
        coupon:     'VALE20'
    );
    $output = $this->placeOrder->execute($placeOrderInput);
    $serverRequest = new ServerRequest(uri: "/rest/v1/order/{$output->code}", method: 'GET');
    $response = handle($serverRequest);
    expect($response->getHeaderLine('content-type'))->toBe('application/hal+json');
    expect($response->getStatusCode())->toBe(200);
    expect($response->getBody()->getContents())
        ->toBeJson()
        ->json()
        ->toBe([
           "id" => 1,
           "code" => date('Y') . "00000001",
           "cpf" => "93541134780",
           "freight" => 1240.00,
           "orderItems" => [
               [
                   "category" => "Música",
                   "description" => "CD",
                   "price" => 1000.0,
               ],
               [
                   "category" => "Vídeo",
                   "description" => "DVD",
                   "price" => 50.00,
               ],
               [
                   "category" => "Vídeo",
                   "description" => "VHS",
                   "price" => 25.00,
               ],
           ],
           "_links" => [
               "self" => [
                   "href" => "/rest/v1/order/" . date('Y') . "00000001"
               ]
           ]
        ]);
});

test('Deve retornas 404 para um código inválido', function () {
    $request = new ServerRequest(uri: "/rest/v1/order/202100000001", method: 'GET');
    $response = handle($request);
    expect($response->getHeaderLine('content-type'))->toBe('application/problem+json');
    expect($response->getStatusCode())->toBe(404);
    expect($response->getBody()->getContents())
        ->toBeJson()
        ->json()
        ->toBe([
            "title" => "Not Found",
            "type" => "https://httpstatus.es/404",
            "status" => 404,
            "detail" => "Order (202100000001) not found"
        ]);
});

test('Deve retornar uma lista de pedidos', function () {
    $placeOrderInput = new PlaceOrderInput(
        cpf:        '935.411.347-80',
        orderItems: [
            new PlaceOrderInputItem(...['idItem' => 1, 'quantity' => 1]),
            new PlaceOrderInputItem(...['idItem' => 2, 'quantity' => 1]),
            new PlaceOrderInputItem(...['idItem' => 3, 'quantity' => 3]),
        ],
        date:       new DateTimeImmutable(),
        coupon:     'VALE20'
    );
    $this->placeOrder->execute($placeOrderInput);
    $this->placeOrder->execute($placeOrderInput);
    $serverRequest = new ServerRequest(uri: "/rest/v1/order", method: 'GET');
    $response = handle($serverRequest);
    expect($response->getHeaderLine('content-type'))->toBe('application/hal+json');
    expect($response->getStatusCode())->toBe(200);
    expect($response->getBody()->getContents())
        ->toBeJson()
        ->json()
        ->toBe([
            "_total_items" => 2,
            "_page" => 1,
            "_page_count" => 1,
            "_links" => [
               "self" => [
                   "href" => "/rest/v1/order?page=1"
               ]
            ],
            "_embedded" => [
                "get.rest.v1.order.code" => [
                    [
                        "id" => 1,
                        "code" => date('Y') . "00000001",
                        "cpf" => "93541134780",
                        "freight" => 1240.00,
                        "orderItems" => [
                            [
                                "category" => "Música",
                                "description" => "CD",
                                "price" => 1000.0,
                            ],
                            [
                                "category" => "Vídeo",
                                "description" => "DVD",
                                "price" => 50.00,
                            ],
                            [
                                "category" => "Vídeo",
                                "description" => "VHS",
                                "price" => 25.00,
                            ],
                        ],
                        "_links" => [
                            "self" => [
                                "href" => "/rest/v1/order/" . date('Y') . "00000001"
                            ]
                        ]
                    ],
                    [
                        "id" => 2,
                        "code" => date('Y') . "00000002",
                        "cpf" => "93541134780",
                        "freight" => 1240.00,
                        "orderItems" => [
                            [
                                "category" => "Música",
                                "description" => "CD",
                                "price" => 1000.0,
                            ],
                            [
                                "category" => "Vídeo",
                                "description" => "DVD",
                                "price" => 50.00,
                            ],
                            [
                                "category" => "Vídeo",
                                "description" => "VHS",
                                "price" => 25.00,
                            ],
                        ],
                        "_links" => [
                            "self" => [
                                "href" => "/rest/v1/order/" . date('Y') . "00000002"
                            ]
                        ]
                    ]
                ]
            ]
        ]);
});

test('Deve fazer um pedido', function () {
    $serverRequest = new ServerRequest(uri: "/rest/v1/order", method: 'POST', parsedBody: [
        "cpf" => "935.411.347-80",
        "coupon" => "VALE20",
        "orderItems" => [
            ["idItem" => 1, "quantity" => 1],
            ["idItem" => 2, "quantity" => 1],
            ["idItem" => 3, "quantity" => 3],
        ],
    ]);
    $response = handle($serverRequest);
    expect($response->getHeaderLine('content-type'))->toBe('application/hal+json');
    expect($response->getStatusCode())->toBe(201);
    expect($response->getBody()->getContents())
        ->toBeJson()
        ->json()
        ->toBe([
           "code" => date("Y") . "00000001",
           "total" => 2365.00,
           "_links" => [
               "self" => [
                   "href" => "/rest/v1/order/" . date('Y') . "00000001"
               ]
           ]
        ]);
});
