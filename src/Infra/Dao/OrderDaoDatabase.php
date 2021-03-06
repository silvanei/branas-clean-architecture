<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Dao;

use PDO;
use Silvanei\BranasCleanArchitecture\Application\Dao\OrderDao;
use Silvanei\BranasCleanArchitecture\Application\Dao\OrderDto;
use Silvanei\BranasCleanArchitecture\Application\Dao\OrderItemsDto;
use Silvanei\BranasCleanArchitecture\Application\Query\PaginatorInput;
use Silvanei\BranasCleanArchitecture\Application\Query\PaginatorSequence;
use Silvanei\BranasCleanArchitecture\Infra\Database\PDODataMapper;

class OrderDaoDatabase implements OrderDao
{
    public function __construct(private PDO $connection)
    {
    }

    public function getOrder(string $code): ?OrderDto
    {
        $stmt = $this->connection->prepare("SELECT id_order AS id, code, cpf, freight FROM ccca.order WHERE code = :code");
        $stmt->execute([':code' => $code]);
        /** @var array<string, string>|false $order */
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        if (! $order) {
            return null;
        }
        return PDODataMapper::map(OrderDto::class, $order);
    }

    public function getOrders(PaginatorInput $paginatorInput): PaginatorSequence
    {
        $stmt = $this->connection->prepare("
            SELECT id_order AS id, code, cpf, freight 
            FROM ccca.order
            LIMIT :limit OFFSET :offset
        ");
        $stmt->execute([':limit' => $paginatorInput->limit(), ':offset' => $paginatorInput->offset()]);
        /** @var array<string, string>[]|false $order */
        $order = $stmt->fetchAll();
        if (! $order) {
            return new PaginatorSequence();
        }
        $order = PDODataMapper::arrayMap(OrderDto::class, $order);
        return new PaginatorSequence($paginatorInput->page, $paginatorInput->itemCountPerPage, $this->getOrdersCount(), $order);
    }


    private function getOrdersCount(): int
    {
        $stmt = $this->connection->prepare("
            SELECT count(1)
            FROM ccca.order
        ");
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function getOrderItems(string $code): ?array
    {
        $stmt = $this->connection->prepare("
            SELECT i.category, i.description, oi.price
            FROM ccca.order_item oi
            INNER JOIN ccca.order o on o.id_order = oi.id_order
            INNER JOIN ccca.item i ON i.id_item = oi.id_item
            WHERE o.code = :code
        ");
        $stmt->execute([':code' => $code]);
        /** @var array<string, string>[]|false $orderItems */
        $orderItems = $stmt->fetchAll();
        if (! $orderItems) {
            return null;
        }
        return PDODataMapper::arrayMap(OrderItemsDto::class, $orderItems);
    }
}
