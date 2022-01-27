<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Repository\Database;

use DateTimeImmutable;
use PDO;
use Silvanei\BranasCleanArchitecture\Domain\Entity\Coupon;
use Silvanei\BranasCleanArchitecture\Domain\Repository\CouponRepository;
use Silvanei\BranasCleanArchitecture\Infra\Database\PDODataMapper;
use Silvanei\BranasCleanArchitecture\Infra\Repository\Database\Dto\CouponDto;

final class CouponRepositoryDatabase implements CouponRepository
{
    public function __construct(private PDO $connection)
    {
    }

    public function findByCode(string $code): ?Coupon
    {
        $stmt = $this->connection->prepare("SELECT * FROM ccca.coupon WHERE code = :code");
        $stmt->execute([':code' => $code]);
        /** @var array<string, string>|false $data */
        $data = $stmt->fetch();
        if ($data) {
            $item = PDODataMapper::map(CouponDto::class, $data);
            return new Coupon(
                $item->code,
                $item->percentage,
                new DateTimeImmutable($item->expire_date),
            );
        }

        return null;
    }
}
