<?php

declare(strict_types=1);

use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Silvanei\BranasCleanArchitecture\Application\Dao\ItemDao;
use Silvanei\BranasCleanArchitecture\Application\Dao\OrderDao;
use Silvanei\BranasCleanArchitecture\Application\Query\Item\GetItem;
use Silvanei\BranasCleanArchitecture\Application\Query\Item\GetItems;
use Silvanei\BranasCleanArchitecture\Application\Query\Order\GetOrder;
use Silvanei\BranasCleanArchitecture\Application\Query\Order\GetOrders;
use Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder\PlaceOrder;
use Silvanei\BranasCleanArchitecture\Application\UseCase\SimulateFreight\SimulateFreight;
use Silvanei\BranasCleanArchitecture\Application\UseCase\ValidateCoupon\ValidateCoupon;
use Silvanei\BranasCleanArchitecture\Domain\Entity\DefaultFreightCalculator;
use Silvanei\BranasCleanArchitecture\Domain\Entity\FreightCaculator;
use Silvanei\BranasCleanArchitecture\Domain\Repository\CouponRepository;
use Silvanei\BranasCleanArchitecture\Domain\Repository\ItemRepository;
use Silvanei\BranasCleanArchitecture\Domain\Repository\OrderRepository;
use Silvanei\BranasCleanArchitecture\Infra\Command\OrderListCommand;
use Silvanei\BranasCleanArchitecture\Infra\Dao\ItemDaoDatabase;
use Silvanei\BranasCleanArchitecture\Infra\Dao\OrderDaoDatabase;
use Silvanei\BranasCleanArchitecture\Infra\Database\PDOConnectionFactory;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\Item\ItemResource;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\Order\OrderResource;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\RenderResourceMiddleware;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\SimulateFreight\SimulateFreightResource;
use Silvanei\BranasCleanArchitecture\Infra\Http\Resource\ValidateCoupon\ValidateCouponResource;
use Silvanei\BranasCleanArchitecture\Infra\Repository\Database\CouponRepositoryDatabase;
use Silvanei\BranasCleanArchitecture\Infra\Repository\Database\ItemRepositoryDatabase;
use Silvanei\BranasCleanArchitecture\Infra\Repository\Database\OrderRepositoryDatabase;

return [
    'dependencies' => [
        'aliases' => [
            ItemRepository::class => ItemRepositoryDatabase::class,
            CouponRepository::class => CouponRepositoryDatabase::class,
            OrderRepository::class => OrderRepositoryDatabase::class,
            FreightCaculator::class => DefaultFreightCalculator::class,
            OrderDao::class => OrderDaoDatabase::class,
            ItemDao::class => ItemDaoDatabase::class,
        ],
        'invokables' => [
        ],
        'factories' => [
            PDO::class => PDOConnectionFactory::class,
            DefaultFreightCalculator::class => ReflectionBasedAbstractFactory::class,

            // Use Case
            PlaceOrder::class => ReflectionBasedAbstractFactory::class,
            SimulateFreight::class => ReflectionBasedAbstractFactory::class,
            ValidateCoupon::class => ReflectionBasedAbstractFactory::class,

            // Repository
            ItemRepositoryDatabase::class => ReflectionBasedAbstractFactory::class,
            OrderRepositoryDatabase::class => ReflectionBasedAbstractFactory::class,
            CouponRepositoryDatabase::class => ReflectionBasedAbstractFactory::class,

            // Dao
            OrderDaoDatabase::class => ReflectionBasedAbstractFactory::class,
            ItemDaoDatabase::class => ReflectionBasedAbstractFactory::class,

            // Query
            GetOrder::class => ReflectionBasedAbstractFactory::class,
            GetOrders::class => ReflectionBasedAbstractFactory::class,
            GetItem::class => ReflectionBasedAbstractFactory::class,
            GetItems::class => ReflectionBasedAbstractFactory::class,

            // Http Resources
            RenderResourceMiddleware::class => ReflectionBasedAbstractFactory::class,
            ItemResource::class => ReflectionBasedAbstractFactory::class,
            OrderResource::class => ReflectionBasedAbstractFactory::class,
            SimulateFreightResource::class => ReflectionBasedAbstractFactory::class,
            ValidateCouponResource::class => ReflectionBasedAbstractFactory::class,

            // Command
            OrderListCommand::class => ReflectionBasedAbstractFactory::class,
        ],
    ],
];
