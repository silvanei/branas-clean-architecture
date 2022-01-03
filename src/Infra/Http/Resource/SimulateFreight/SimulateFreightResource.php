<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Http\Resource\SimulateFreight;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Silvanei\BranasCleanArchitecture\Application\UseCase\SimulateFreight\SimulateFreight;
use Silvanei\BranasCleanArchitecture\Application\UseCase\SimulateFreight\SimulateFreightInput;
use Silvanei\BranasCleanArchitecture\Application\UseCase\SimulateFreight\SimulateFreightInputItem;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\AbstractResource;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\ProblemDetailsException;
use Throwable;

final class SimulateFreightResource extends AbstractResource
{
    public function __construct(private SimulateFreight $simulateFreight)
    {
    }

    public function post(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $simulateFreitghtItens = array_map(
                callback: fn($item) => new SimulateFreightInputItem(idItem: $item['idItem'], quantity: $item['quantity']),
                array: (array)$request->getParsedBody()
            );
            $inputData = new SimulateFreightInput(...$simulateFreitghtItens);
            $result = (array)$this->simulateFreight->execute($inputData);
            return new JsonResponse($result);
        } catch (Throwable $exception) {
            throw ProblemDetailsException::badRequest($exception->getMessage());
        }
    }
}
