<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture;

use DateTimeImmutable;
use Ds\Vector;

final class Order
{
    /** @var Vector<OrderItem> */
    private Vector $items;
    private ?Coupon $coupon = null;
    private int|float $freight = 0;

    public function __construct(
        public readonly Cpf $cpf,
        private DateTimeImmutable $date,
        private FreightCaculator $freightCaculator = new DefaultFreightCalculator()
    ) {
        $this->items = new Vector();
    }

    public function add(Item $item, int $quantity): void
    {
        $this->freight += $this->freightCaculator->calculate($item) * $quantity;
        $this->items->push(new OrderItem($item->id, $item->price, $quantity));
    }

    public function addCoupon(Coupon $coupon): void
    {
        $this->coupon = $coupon;
    }

    public function freight(): int|float
    {
        return $this->freight;
    }

    public function total(): int|float
    {
        $total = 0;
        foreach ($this->items as $orderItem) {
            $total += $orderItem->total();
        }
        if ($this->coupon) {
            return $this->coupon->discount($total, $this->date);
        }
        $total += $this->freight;
        return $total;
    }
}
