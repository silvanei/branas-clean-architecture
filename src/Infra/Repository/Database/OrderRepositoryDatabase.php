<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Repository\Database;

use DomainException;
use PDO;
use PDOException;
use Silvanei\BranasCleanArchitecture\Domain\Entity\Order;
use Silvanei\BranasCleanArchitecture\Domain\Repository\OrderRepository;

final class OrderRepositoryDatabase implements OrderRepository
{
    public function __construct(private PDO $connection)
    {
    }

    public function save(Order $order): void
    {
        $insertOrder = '
            INSERT INTO ccca.order (coupon, code, cpf, issue_date, freight, sequence)
            VALUES (:coupon, :code, :cpf, :issue_date, :freight, :sequence)
        ';
        $insertOrderItem = '
            INSERT INTO ccca.order_item (id_order, id_item, price, quantity)
            VALUES (:id_order, :id_item, :price, :quantity)
        ';
        try {
            $this->connection->beginTransaction();
            $this->connection->prepare($insertOrder)->execute([
                ':coupon' => $order->coupon(),
                ':code' => $order->code(),
                ':cpf' => $order->cpf(),
                ':issue_date' => $order->date()->format('Y-m-d H:i:s'),
                ':freight' => $order->freight(),
                ':sequence' => $order->sequence()
            ]);
            $orderId = $this->connection->lastInsertId();
            foreach ($order->items() as $item) {
                $this->connection->prepare($insertOrderItem)->execute([
                    ':id_order' => $orderId,
                    ':id_item' => $item->idItem,
                    ':price' => $item->price,
                    ':quantity' => $item->quantity,
                ]);
            }
            $this->connection->commit();
        } catch (PDOException $exception) {
            $this->connection->rollBack();
            throw new DomainException($exception->getMessage());
        }
    }

    public function count(): int
    {
        $stmt = $this->connection->prepare("SELECT count(1) AS total from ccca.order");
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function nextSequence(): int
    {
        $stmt = $this->connection->prepare("SELECT nextval('ccca.order_sequence') AS sequence");
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
}
