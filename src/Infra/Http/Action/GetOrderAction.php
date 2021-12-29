<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Http\Action;

use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Silvanei\BranasCleanArchitecture\Application\Query\GetOrder;
use Silvanei\BranasCleanArchitecture\Application\Query\GetOrders;

class GetOrderAction implements RequestHandlerInterface
{
    public function __construct(private GetOrder $getOrder, private GetOrders $getOrders)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = null;
        $code = $request->getAttributes()['code'] ?? null;
        if ($code) {
            $response = $this->getOrder->execute($code);
        }
        if (! $code) {
            $response = $this->getOrders->execute();
        }
        if (! $response) {
            return new EmptyResponse(404);
        }
        return new JsonResponse($response, 200);
    }
}
