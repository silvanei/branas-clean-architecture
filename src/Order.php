<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture;

final class Order
{
    /** @var OrderItem[]  */
    private array $items = [];

    public function __construct(public readonly Cpf $cpf, private ?Coupon $coupon = null)
    {
    }

    public function add(Item $item, int $quantity): void
    {
        $this->items[] = new OrderItem($item->id, $item->price, $quantity);
    }

    public function total(): int|float
    {
        $total = 0;
        foreach ($this->items as $orderItem) {
            $total += $orderItem->total();
        };
        if ($this->coupon) {
            return $this->coupon->discount($total);
        }
        return $total;
    }
}
