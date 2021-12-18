<?php

namespace Silvanei\BranasCleanArchitecture\Domain\Repository;

use Silvanei\BranasCleanArchitecture\Domain\Entity\Item;

interface ItemRepository
{
    public function findById(int $id): ?Item;
}
