<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Repository\Memory;

use Silvanei\BranasCleanArchitecture\Domain\Entity\Item;
use Silvanei\BranasCleanArchitecture\Domain\Repository\ItemRepository;

final class ItemRepositoryMemory implements ItemRepository
{
    /** @var Item[] */
    private array $items;

    public function __construct()
    {
        $this->items = [
            new Item(1, 'Categoria 1', 'Descrição 1', 1000, 20, 15, 10, 1),
            new Item(2, 'Categoria 2', 'Descrição 2', 50, 100, 30, 10, 3),
            new Item(3, 'Categoria 3', 'Descrição 3', 25, 200, 100, 50, 40),
            new Item(4, "Instrumentos Musicais", "Guitarra", 1000, 100, 30, 10, 3),
            new Item(5, "Instrumentos Musicais", "Amplificador", 5000, 100, 50, 50, 20),
            new Item(6, "Acessórios", "Cabo", 30, 10, 10, 10, 0.9),
        ];
    }

    public function findById(int $id): ?Item
    {
        foreach ($this->items as $item) {
            if ($item->id === $id) {
                return $item;
            }
        }
        return null;
    }
}
