<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\Query\Order;

use RuntimeException;
use Silvanei\BranasCleanArchitecture\Application\Dao\OrderDao;
use Silvanei\BranasCleanArchitecture\Application\Dao\OrderDto;
use Silvanei\BranasCleanArchitecture\Application\Query\PaginatorInput;
use Silvanei\BranasCleanArchitecture\Application\Query\PaginatorSequence;

final class GetOrders
{
    public function __construct(private OrderDao $orderDao)
    {
    }

    /**
     * @param PaginatorInput $paginatorInput
     * @return PaginatorSequence<GetOrderOutput>
     */
    public function execute(PaginatorInput $paginatorInput): PaginatorSequence
    {
        $orders = $this->orderDao->getOrders($paginatorInput);
        return $orders->map(function (OrderDto $order) {
            $orderItems = $this->orderDao->getOrderItems($order->code);
            if (! $orderItems) {
                throw new RuntimeException("Item not found");
            }
            return new GetOrderOutput($order->id, $order->code, $order->cpf, $order->freight, $orderItems);
        });
    }
}
