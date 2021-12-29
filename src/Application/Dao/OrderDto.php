<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Application\Dao;

class OrderDto
{
    public readonly int $id;
    public readonly string $code;
    public readonly string $cpf;
    public readonly float $freight;
}
