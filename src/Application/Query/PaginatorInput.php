<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\Query;

final class PaginatorInput
{
    public function __construct(public readonly int $page, public readonly int $itemCountPerPage)
    {
    }

    public function limit(): int
    {
        return $this->itemCountPerPage;
    }

    public function offset(): int
    {
        return ($this->page - 1) * $this->itemCountPerPage;
    }
}
