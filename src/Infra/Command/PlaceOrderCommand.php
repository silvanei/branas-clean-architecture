<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Command;

use Silvanei\BranasCleanArchitecture\Application\Query\GetOrder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PlaceOrderCommand extends Command
{
    public function __construct(private GetOrder $getOrder)
    {
        parent::__construct('place-order:list');
    }

    protected function configure(): void
    {
        $this->addArgument('code', InputArgument::REQUIRED, 'Place order code');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $code = $input->getArgument('code') . "";
        $order = $this->getOrder->execute($code);
        if (! $order) {
            $output->writeln("Order not found.");
            return Command::SUCCESS;
        }
        $order = (array)$order;
        $orderItems = $order['orderItems'];
        unset($order['orderItems']);
        $orders = array_map(fn($orderItems) => [...$order, ...$orderItems], $orderItems);
        $table = new Table($output);
        $table->setHeaders(array_keys($orders[0]));
        $table->setRows($orders);
        $table->render();
        return Command::SUCCESS;
    }
}
