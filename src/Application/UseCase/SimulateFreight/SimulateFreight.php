<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\UseCase\SimulateFreight;

use Decimal\Decimal;
use InvalidArgumentException;
use Silvanei\BranasCleanArchitecture\Domain\Entity\FreightCaculator;
use Silvanei\BranasCleanArchitecture\Domain\Repository\ItemRepository;

final class SimulateFreight
{
    public function __construct(private ItemRepository $itemRepository, private FreightCaculator $freightCaculator)
    {
    }

    public function execute(SimulateFreightInput $simulateFreightInput): SimulateFreightOutput
    {
        $amount = new Decimal(0);
        foreach ($simulateFreightInput->items as $inputItem) {
            $item = $this->itemRepository->findById($inputItem->idItem);
            if (! $item) {
                throw new InvalidArgumentException("Item ($inputItem->idItem) not found");
            }
            $freightValue = $this->freightCaculator->calculate($item)->mul($inputItem->quantity);
            $amount = $amount->add($freightValue);
        }
        return new SimulateFreightOutput($amount->toFloat());
    }
}
