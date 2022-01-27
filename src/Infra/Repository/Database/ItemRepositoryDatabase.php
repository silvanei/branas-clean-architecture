<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Repository\Database;

use Decimal\Decimal;
use PDO;
use Silvanei\BranasCleanArchitecture\Domain\Entity\Item;
use Silvanei\BranasCleanArchitecture\Domain\Repository\ItemRepository;
use Silvanei\BranasCleanArchitecture\Infra\Database\PDODataMapper;
use Silvanei\BranasCleanArchitecture\Infra\Repository\Database\Dto\ItemDto;

final class ItemRepositoryDatabase implements ItemRepository
{
    public function __construct(private PDO $connection)
    {
    }

    public function findById(int $id): ?Item
    {
        $stmt = $this->connection->prepare("SELECT * FROM ccca.item WHERE id_item = :id_item");
        $stmt->execute([':id_item' => $id]);
        /** @var array<string, string>|false $data */
        $data = $stmt->fetch();
        if (! $data) {
            return null;
        }
        $item = PDODataMapper::map(ItemDto::class, $data);
        return new Item(
            $item->id_item,
            $item->category,
            $item->description,
            new Decimal($item->price),
            $item->width,
            $item->height,
            $item->length,
            $item->weight,
        );
    }
}
