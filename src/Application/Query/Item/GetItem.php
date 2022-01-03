<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\Query\Item;

use Silvanei\BranasCleanArchitecture\Application\Dao\ItemDao;

final class GetItem
{
    public function __construct(private ItemDao $itemDao)
    {
    }

    public function execute(int $id): ?GetItemOutput
    {
        $item = $this->itemDao->getItem($id);
        if (! $item) {
            return null;
        }
        return new GetItemOutput(...(array)$item);
    }
}
