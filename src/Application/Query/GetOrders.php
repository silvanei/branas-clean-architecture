<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\Query;

use Silvanei\BranasCleanArchitecture\Application\Dao\OrderDao;

final class GetOrders
{
    public function __construct(private OrderDao $orderDao, private GetOrder $getOrder)
    {
    }

    /** @return GetOrderOutput[] */
    public function execute(): array
    {
        $ordersOutput = [];
        $orders = $this->orderDao->getOrders();
        foreach ($orders as $order) {
            $ordersOutput[] = $this->getOrder->execute($order->code);
        }
        return array_filter($ordersOutput);
    }
}
