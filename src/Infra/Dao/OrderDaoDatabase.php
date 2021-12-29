<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Dao;

use PDO;
use Silvanei\BranasCleanArchitecture\Application\Dao\OrderDao;
use Silvanei\BranasCleanArchitecture\Application\Dao\OrderDto;
use Silvanei\BranasCleanArchitecture\Application\Dao\OrderItemsDto;

class OrderDaoDatabase implements OrderDao
{
    public function __construct(private PDO $connection)
    {
    }

    public function getOrder(string $code): ?OrderDto
    {
        $stmt = $this->connection->prepare("SELECT id_order AS id, code, cpf, freight FROM ccca.order WHERE code = :code");
        $stmt->setFetchMode(PDO::FETCH_CLASS, OrderDto::class);
        $stmt->execute([':code' => $code]);
        /** @var OrderDto|false $order */
        $order = $stmt->fetch();
        if (! $order) {
            return null;
        }
        return $order;
    }

    /**
     * @return OrderDto[]
     */
    public function getOrders(): array
    {
        $stmt = $this->connection->prepare("SELECT id_order AS id, code, cpf, freight FROM ccca.order");
        $stmt->setFetchMode(PDO::FETCH_CLASS, OrderDto::class);
        $stmt->execute();
        /** @var OrderDto[]|false $order */
        $order = $stmt->fetchAll();
        if (! $order) {
            return [];
        }
        return $order;
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
        $stmt->setFetchMode(PDO::FETCH_CLASS, OrderItemsDto::class);
        $stmt->execute([':code' => $code]);
        /** @var ?OrderItemsDto[] $orderItems */
        $orderItems = $stmt->fetchAll();
        if (! $orderItems) {
            return null;
        }
        return $orderItems;
    }
}
