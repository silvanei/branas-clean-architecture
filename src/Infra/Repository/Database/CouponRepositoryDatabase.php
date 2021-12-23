<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Repository\Database;

use DateTimeImmutable;
use PDO;
use Silvanei\BranasCleanArchitecture\Domain\Entity\Coupon;
use Silvanei\BranasCleanArchitecture\Domain\Repository\CouponRepository;
use Silvanei\BranasCleanArchitecture\Infra\Repository\Database\Dto\CouponDto;

final class CouponRepositoryDatabase implements CouponRepository
{
    public function __construct(private PDO $connection)
    {
    }

    public function findByCode(string $code): ?Coupon
    {
        $stmt = $this->connection->prepare("SELECT * FROM ccca.coupon WHERE code = :code");
        $stmt->setFetchMode(PDO::FETCH_CLASS, CouponDto::class);
        $stmt->execute([':code' => $code]);
        /** @var CouponDto|false $item */
        $item = $stmt->fetch();
        if ($item) {
            return new Coupon(
                $item->code,
                $item->percentage,
                new DateTimeImmutable($item->expire_date),
            );
        }

        return null;
    }
}
