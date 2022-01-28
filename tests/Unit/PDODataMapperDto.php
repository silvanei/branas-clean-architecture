<?php

declare(strict_types=1);

namespace Tests\Silvanei\BranasCleanArchitecture\Unit;

class PDODataMapperDto
{
    public function __construct(
        public int $id,
        public string $name,
        public float $price,
    ) {
    }
}
