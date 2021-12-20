<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Domain\Entity;

use DateTimeImmutable;

final class OrderCode
{
    public readonly string $value;

    public function __construct(DateTimeImmutable $date, int $sequence)
    {
        $year = $date->format('Y');
        $fullSequence = str_pad((string)$sequence, 8, '0', STR_PAD_LEFT);
        $this->value = "{$year}{$fullSequence}";
    }
}
