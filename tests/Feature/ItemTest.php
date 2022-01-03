<?php

use Laminas\Diactoros\ServerRequest;

test('Deve retornar um item pelo ID', function () {
    $serverRequest = new ServerRequest(uri: "/rest/v1/item/1", method: 'GET');
    $response = handle($serverRequest);
    expect($response->getHeaderLine('content-type'))->toBe('application/hal+json');
    expect($response->getStatusCode())->toBe(200);
    expect($response->getBody()->getContents())
        ->toBeJson()
        ->json()
        ->toBe([
            "id" => 1,
            "category" => "Música",
            "description" => "CD",
            "price" => 1000.00,
            "_links" => [
                "self" => [
                    "href" => "/rest/v1/item/1"
                ]
            ]
        ]);
});

test('Deve retornar uma lista de items', function () {
    $serverRequest = new ServerRequest(uri: "/rest/v1/item", method: 'GET');
    $response = handle($serverRequest);
    expect($response->getHeaderLine('content-type'))->toBe('application/hal+json');
    expect($response->getStatusCode())->toBe(200);
    expect($response->getBody()->getContents())
        ->toBeJson()
        ->json()
        ->toBe([
            "_total_items" => 6,
            "_page" => 1,
            "_page_count" => 1,
            "_links" => [
                "self" => [
                    "href" => "/rest/v1/item?page=1"
                ]
            ],
            "_embedded" => [
                "get.rest.v1.item.id" => [
                    [
                        "id" => 1,
                        "category" => "Música",
                        "description" => "CD",
                        "price" => 1000.00,
                        "_links" => [
                            "self" => [
                               "href" => "/rest/v1/item/1"
                            ]
                        ]
                    ],
                    [
                        "id" => 2,
                        "category" => "Vídeo",
                        "description" => "DVD",
                        "price" => 50.00,
                        "_links" => [
                            "self" => [
                                "href" => "/rest/v1/item/2"
                            ]
                        ]
                    ],
                    [
                        "id" => 3,
                        "category" => "Vídeo",
                        "description" => "VHS",
                        "price" => 25.00,
                        "_links" => [
                            "self" => [
                                "href" => "/rest/v1/item/3"
                            ]
                        ]
                    ],
                    [
                        "id" => 4,
                        "category" => "Instrumentos Musicais",
                        "description" => "Guitarra",
                        "price" => 1000.00,
                        "_links" => [
                            "self" => [
                                "href" => "/rest/v1/item/4"
                            ]
                        ]
                    ],
                    [
                        "id" => 5,
                        "category" => "Instrumentos Musicais",
                        "description" => "Amplificador",
                        "price" => 5000.00,
                        "_links" => [
                            "self" => [
                                "href" => "/rest/v1/item/5"
                            ]
                        ]
                    ],
                    [
                        "id" => 6,
                        "category" => "Acessórios",
                        "description" => "Cabo",
                        "price" => 30.00,
                        "_links" => [
                            "self" => [
                                "href" => "/rest/v1/item/6"
                            ]
                        ]
                    ]
                ]
            ]
        ]);
});
