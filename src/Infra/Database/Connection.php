<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Database;

use PDO;

class Connection
{
    private static ?PDO $instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $dsn = (string)getenv('PDO_DSN');
            $user = (string)getenv('PDO_USER');
            $pass = (string)getenv('PDO_PASS');
            self::$instance = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }
        return self::$instance;
    }
}
