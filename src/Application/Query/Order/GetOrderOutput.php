<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\Query\Order;

use Silvanei\BranasCleanArchitecture\Application\Dao\OrderItemsDto;

class GetOrderOutput
{
    public function __construct(
        public readonly int $id,
        public readonly string $code,
        public readonly string $cpf,
        public readonly float $freight,
        /** @var OrderItemsDto[]*/
        public readonly array $orderItems,
    ) {
    }
}
