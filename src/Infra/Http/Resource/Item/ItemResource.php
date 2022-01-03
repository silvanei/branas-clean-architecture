<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Http\Resource\Item;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Silvanei\BranasCleanArchitecture\Application\Query\Item\GetItem;
use Silvanei\BranasCleanArchitecture\Application\Query\Item\GetItems;
use Silvanei\BranasCleanArchitecture\Application\Query\PaginatorInput;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\AbstractResource;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\PaginatorSequenceAdapter;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\ProblemDetailsException;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\ResourceResponse;

final class ItemResource extends AbstractResource
{
    public function __construct(private GetItem $getItem, private GetItems $getItems)
    {
    }

    public function get(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttributes()['id'] ?? null;
        if (! $id) {
            return $this->getAll($request);
        }
        $item = $this->getItem->execute((int)$id);
        if (! $item) {
            throw ProblemDetailsException::notFound("Item ($id) not found");
        }
        return new ResourceResponse($item, 200);
    }

    public function getAll(ServerRequestInterface $request): ResponseInterface
    {
        $page = $request->getQueryParams()['page'] ?? 1;
        $itemCountPerPage = $request->getQueryParams()['count-per-page'] ?? 10;
        $paginatorInput = new PaginatorInput((int)$page, (int)$itemCountPerPage);
        $items = $this->getItems->execute($paginatorInput);
        $collection = new GetItemOutputCollection(new PaginatorSequenceAdapter($items));
        $collection->setItemCountPerPage($items->itemCountPerPage);
        $collection->setCurrentPageNumber($items->page);
        return new ResourceResponse($collection, 200);
    }
}
