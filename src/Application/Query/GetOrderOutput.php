<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\Query;

class GetOrderOutput
{
    public function __construct(
        public readonly int $id,
        public readonly string $code,
        public readonly string $cpf,
        public readonly float $freight,
        /** @var array{"category": string, "description": string, "price": float}[] */
        public readonly array $orderItems,
    ) {
    }
}
