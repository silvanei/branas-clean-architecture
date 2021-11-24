<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture;

final class Order
{
    /** @var array<OrderItem>  */
    private array $items = [];

    public function __construct(public readonly Cpf $cpf, private ?Coupon $coupon = null)
    {
    }

    public function add(OrderItem $orderItem): void
    {
        $this->items[] = $orderItem;
    }

    public function total(): int|float
    {
        $total = array_reduce(
            array: $this->items,
            callback: fn($total, OrderItem $item) => $total + $item->total(),
            initial: 0
        );
        if ($this->coupon) {
            return $this->coupon->discount($total);
        }
        return $total;
    }
}
