<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Http\Action;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Silvanei\BranasCleanArchitecture\Application\UseCase\SimulateFreight\SimulateFreight;
use Silvanei\BranasCleanArchitecture\Application\UseCase\SimulateFreight\SimulateFreightInput;
use Silvanei\BranasCleanArchitecture\Application\UseCase\SimulateFreight\SimulateFreightInputItem;

class SimulateFreightAction implements RequestHandlerInterface
{
    public function __construct(private SimulateFreight $simulateFreight)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $simulateFreitghtItens = array_map(
            callback: fn($item) => new SimulateFreightInputItem(idItem: $item['idItem'], quantity: $item['quantity']),
            array: (array)$request->getParsedBody()
        );
        $inputData = new SimulateFreightInput(...$simulateFreitghtItens);
        $result = (array)$this->simulateFreight->execute($inputData);
        return new JsonResponse($result);
    }
}
