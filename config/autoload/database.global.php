<?php

return [
    'db' => [
        'dsn' => getenv('PDO_DSN'),
        'username' => getenv('PDO_USER'),
        'password' => getenv('PDO_PASS'),
        'driver_options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ],
    ]
];
