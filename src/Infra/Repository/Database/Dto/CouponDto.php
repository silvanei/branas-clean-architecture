<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Repository\Database\Dto;

class CouponDto
{
    public readonly string $code;
    public readonly int $percentage;
    public readonly string $expire_date;
}
