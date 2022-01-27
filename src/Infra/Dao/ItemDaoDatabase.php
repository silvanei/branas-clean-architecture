<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Dao;

use PDO;
use Silvanei\BranasCleanArchitecture\Application\Dao\ItemDao;
use Silvanei\BranasCleanArchitecture\Application\Dao\ItemDto;
use Silvanei\BranasCleanArchitecture\Application\Query\PaginatorInput;
use Silvanei\BranasCleanArchitecture\Application\Query\PaginatorSequence;
use Silvanei\BranasCleanArchitecture\Infra\Database\PDODataMapper;

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
        $stmt->execute([':id' => $id]);
        /** @var array<string, string> $data */
        $data = $stmt->fetch();
        if (! $data) {
            return null;
        }
        return PDODataMapper::map(ItemDto::class, $data);
    }

    public function getItems(PaginatorInput $paginatorInput): PaginatorSequence
    {
        $stmt = $this->connection->prepare("
            SELECT id_item as id, category, description, price
            FROM ccca.item
            LIMIT :limit OFFSET :offset
        ");
        $stmt->execute([':limit' => $paginatorInput->limit(), ':offset' => $paginatorInput->offset()]);
        /** @var array<string, string>[] $data */
        $data = $stmt->fetchAll();
        if (! $data) {
            return new PaginatorSequence();
        }
        $items = PDODataMapper::arrayMap(ItemDto::class, $data);
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
