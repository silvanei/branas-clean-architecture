<?php

use Silvanei\BranasCleanArchitecture\Infra\Command\OrderListCommand;

return [
    'laminas-cli' => [
        'commands' => [
            'order:list' => OrderListCommand::class,
        ],
    ],
];
