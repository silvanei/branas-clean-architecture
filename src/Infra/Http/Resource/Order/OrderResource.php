<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Http\Resource\Order;

use DateTimeImmutable;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Silvanei\BranasCleanArchitecture\Application\Query\Order\GetOrder;
use Silvanei\BranasCleanArchitecture\Application\Query\Order\GetOrders;
use Silvanei\BranasCleanArchitecture\Application\Query\PaginatorInput;
use Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder\PlaceOrder;
use Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder\PlaceOrderInput;
use Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder\PlaceOrderInputItem;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\AbstractResource;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\PaginatorSequenceAdapter;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\ProblemDetailsException;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\ResourceResponse;
use Throwable;

final class OrderResource extends AbstractResource
{
    public function __construct(private GetOrder $getOrder, private GetOrders $getOrders, private PlaceOrder $placeOrder)
    {
    }

    public function get(ServerRequestInterface $request): ResponseInterface
    {
        $code = $request->getAttributes()['code'] ?? null;
        if (! $code) {
            return $this->getAll($request);
        }
        $response = $this->getOrder->execute($code);
        if (! $response) {
            throw ProblemDetailsException::notFound("Order ($code) not found");
        }
        return new ResourceResponse($response, 200);
    }

    private function getAll(ServerRequestInterface $request): ResponseInterface
    {
        $page = $request->getQueryParams()['page'] ?? 1;
        $itemCountPerPage = $request->getQueryParams()['count-per-page'] ?? 10;
        $paginatorInput = new PaginatorInput((int)$page, (int)$itemCountPerPage);
        $orders = $this->getOrders->execute($paginatorInput);
        $collection = new GetOrderOutputCollection(new PaginatorSequenceAdapter($orders));
        $collection->setItemCountPerPage($orders->itemCountPerPage);
        $collection->setCurrentPageNumber($orders->page);
        return new ResourceResponse($collection, 200);
    }

    public function post(ServerRequestInterface $request): ResponseInterface
    {
        $params = (array)$request->getParsedBody();
        try {
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
            return new ResourceResponse(new PostOrderOutput(...$response), 201);
        } catch (Throwable $exception) {
            throw ProblemDetailsException::badRequest($exception->getMessage());
        }
    }
}
