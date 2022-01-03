<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Dao;

use PDO;
use Silvanei\BranasCleanArchitecture\Application\Dao\ItemDao;
use Silvanei\BranasCleanArchitecture\Application\Dao\ItemDto;
use Silvanei\BranasCleanArchitecture\Application\Query\PaginatorInput;
use Silvanei\BranasCleanArchitecture\Application\Query\PaginatorSequence;

class ItemDaoDatabase implements ItemDao
{
    public function __construct(private PDO $connection)
    {
    }

    public function getItem(int $id): ?ItemDto
    {
        $stmt = $this->connection->prepare("
            SELECT id_item as id, category, description, price
            FROM ccca.item
            WHERE id_item = :id
        ");
        $stmt->setFetchMode(PDO::FETCH_CLASS, ItemDto::class);
        $stmt->execute([':id' => $id]);
        /** @var ?ItemDto $item */
        $item = $stmt->fetch();
        if (! $item) {
            return null;
        }
        return $item;
    }

    public function getItems(PaginatorInput $paginatorInput): PaginatorSequence
    {
        $stmt = $this->connection->prepare("
            SELECT id_item as id, category, description, price
            FROM ccca.item
            LIMIT :limit OFFSET :offset
        ");
        $stmt->setFetchMode(PDO::FETCH_CLASS, ItemDto::class);
        $stmt->execute([':limit' => $paginatorInput->limit(), ':offset' => $paginatorInput->offset()]);
        /** @var ?ItemDto[] $items */
        $items = $stmt->fetchAll();
        if (! $items) {
            return new PaginatorSequence();
        }
        return new PaginatorSequence($paginatorInput->page, $paginatorInput->itemCountPerPage, $this->getItemsCount(), $items);
    }

    private function getItemsCount(): int
    {
        $stmt = $this->connection->prepare("
            SELECT count(1)
            FROM ccca.item
        ");
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
}
