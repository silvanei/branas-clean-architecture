<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder;

use DateTimeImmutable;

final class PlaceOrderInput
{
    public function __construct(
        public readonly string $cpf,
        /** @var PlaceOrderInputItem[] **/
        public readonly array $orderItems,
        public readonly DateTimeImmutable $date,
        public readonly ?string $coupon,
    ) {
    }
}
