<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\Query;

use Silvanei\BranasCleanArchitecture\Application\Dao\OrderDao;
use Silvanei\BranasCleanArchitecture\Application\Dao\OrderItemsDto;

final class GetOrder
{
    public function __construct(private OrderDao $orderDao)
    {
    }

    public function execute(string $code): ?GetOrderOutput
    {
        $order = $this->orderDao->getOrder($code);
        if (! $order) {
            return null;
        }
        $orderItems = $this->orderDao->getOrderItems($code);
        if (! $orderItems) {
            return null;
        }
        $orderItemsArray = array_map(fn(OrderItemsDto $itemsDto) => (array)$itemsDto, $orderItems);
        return new GetOrderOutput($order->id, $order->code, $order->cpf, $order->freight, $orderItemsArray);
    }
}
