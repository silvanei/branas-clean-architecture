<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\Query\Item;

use Silvanei\BranasCleanArchitecture\Application\Dao\ItemDao;
use Silvanei\BranasCleanArchitecture\Application\Dao\ItemDto;
use Silvanei\BranasCleanArchitecture\Application\Query\PaginatorInput;
use Silvanei\BranasCleanArchitecture\Application\Query\PaginatorSequence;

final class GetItems
{
    public function __construct(private ItemDao $itemDao)
    {
    }

    /**
     * @param PaginatorInput $paginatorInput
     * @return PaginatorSequence<GetItemOutput>
     */
    public function execute(PaginatorInput $paginatorInput): PaginatorSequence
    {
        $items = $this->itemDao->getItems($paginatorInput);
        return $items->map(fn(ItemDto $itemDto) => new GetItemOutput(...(array)$itemDto));
    }
}
