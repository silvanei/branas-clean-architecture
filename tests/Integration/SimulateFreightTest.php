<?php

use Silvanei\BranasCleanArchitecture\Application\UseCase\SimulateFreight\SimulateFreight;
use Silvanei\BranasCleanArchitecture\Application\UseCase\SimulateFreight\SimulateFreightInput;
use Silvanei\BranasCleanArchitecture\Application\UseCase\SimulateFreight\SimulateFreightInputItem;
use Silvanei\BranasCleanArchitecture\Domain\Entity\DefaultFreightCalculator;
use Silvanei\BranasCleanArchitecture\Infra\Repository\Memory\ItemRepositoryMemory;

test('Deve simular o frete dos itens', function () {
    $itemRepository = new ItemRepositoryMemory();
    $freightCalculator = new DefaultFreightCalculator();
    $simulateFreitght = new SimulateFreight($itemRepository, $freightCalculator);
    $inputData = new SimulateFreightInput(...[
        new SimulateFreightInputItem(idItem: 4, quantity: 1),
        new SimulateFreightInputItem(idItem: 5, quantity: 1),
        new SimulateFreightInputItem(idItem: 6, quantity: 3),
    ]);
    $output = $simulateFreitght->execute($inputData);
    expect($output->amount)->toBe(260.00);
});
