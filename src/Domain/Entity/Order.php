<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Domain\Entity;

use DateTimeImmutable;
use Decimal\Decimal;
use Ds\Vector;

final class Order
{
    /** @var Vector<OrderItem> */
    private Vector $items;
    private ?Coupon $coupon = null;
    private Decimal $freight;
    private OrderCode $orderCode;

    public function __construct(
        private readonly Cpf $cpf,
        private DateTimeImmutable $date,
        private FreightCaculator $freightCaculator = new DefaultFreightCalculator(),
        private int $sequence = 1,
    ) {
        $this->items = new Vector();
        $this->freight = new Decimal(0);
        $this->orderCode = new OrderCode($this->date, $this->sequence);
    }

    public function add(Item $item, int $quantity): void
    {
        $this->freight = $this->freight->add($this->freightCaculator->calculate($item)->mul($quantity));
        $this->items->push(new OrderItem($item->id, $item->price, $quantity));
    }

    public function addCoupon(Coupon $coupon): void
    {
        if ($coupon->isExpired($this->date)) {
            return;
        }
        $this->coupon = $coupon;
    }

    public function freight(): Decimal
    {
        return $this->freight;
    }

    public function code(): string
    {
        return $this->orderCode->value;
    }

    public function coupon(): ?string
    {
        return $this->coupon?->code;
    }

    public function cpf(): string
    {
        return $this->cpf->value;
    }

    public function date(): DateTimeImmutable
    {
        return $this->date;
    }

    public function sequence(): int
    {
        return $this->sequence;
    }

    /** @return Vector<OrderItem> */
    public function items(): Vector
    {
        return $this->items->copy();
    }

    public function total(): Decimal
    {
        $total = new Decimal(0);
        foreach ($this->items as $orderItem) {
            $total = $total->add($orderItem->total());
        }
        if ($this->coupon) {
            $total = $total->sub($this->coupon->calculateDiscount($total, $this->date));
        }
        return $total->add($this->freight);
    }
}
