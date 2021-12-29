<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Http\Action;

use DateTimeImmutable;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder\PlaceOrder;
use Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder\PlaceOrderInput;
use Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder\PlaceOrderInputItem;

class PlaceOrderAction implements RequestHandlerInterface
{
    public function __construct(private PlaceOrder $placeOrder)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $params = (array)$request->getParsedBody();
        $orderItems = array_map(
            fn($item) => new PlaceOrderInputItem($item['idItem'], $item['quantity']),
            $params['orderItems']
        );
        $placeOrderInput = new PlaceOrderInput(
            cpf: $params['cpf'],
            orderItems: $orderItems,
            date: new DateTimeImmutable(),
            coupon: $params['coupon'] ?? ''
        );
        $response = (array)$this->placeOrder->execute($placeOrderInput);
        return new JsonResponse($response, 201);
    }
}
