<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\UseCase;

use InvalidArgumentException;
use Silvanei\BranasCleanArchitecture\Domain\Entity\Cpf;
use Silvanei\BranasCleanArchitecture\Domain\Entity\DefaultFreightCalculator;
use Silvanei\BranasCleanArchitecture\Domain\Entity\Order;
use Silvanei\BranasCleanArchitecture\Domain\Repository\CouponRepository;
use Silvanei\BranasCleanArchitecture\Domain\Repository\ItemRepository;
use Silvanei\BranasCleanArchitecture\Domain\Repository\OrderRepository;

final class PlaceOrder
{
    public function __construct(
        private ItemRepository $itemRepository,
        private CouponRepository $couponRepository,
        private OrderRepository $orderRepository
    ) {
    }

    public function execute(PlaceOrderInput $input): PlaceOrderOutput
    {
        $sequence = $this->orderRepository->nextSequence();
        $order = new Order(cpf: new Cpf($input->cpf), date: $input->date, freightCaculator: new DefaultFreightCalculator(), sequence: $sequence);
        foreach ($input->orderItems as $orderItem) {
            $item = $this->itemRepository->findById($orderItem->idItem);
            if (! $item) {
                throw new InvalidArgumentException("Item not found");
            }
            $order->add($item, $orderItem->quantity);
        }
        if ($input->coupon) {
            $coupon = $this->couponRepository->findByCode($input->coupon);
            if ($coupon) {
                $order->addCoupon($coupon);
            }
        }
        $this->orderRepository->save($order);
        $total = $order->total();
        return new PlaceOrderOutput($order->code(), $total->toFloat());
    }
}
