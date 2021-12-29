<?php

use Silvanei\BranasCleanArchitecture\Infra\Command\PlaceOrderCommand;

return [
    'laminas-cli' => [
        'commands' => [
            'place-order:list' => PlaceOrderCommand::class,
        ],
    ],
];
