<?php

declare(strict_types=1);

use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Silvanei\BranasCleanArchitecture\Application\Dao\OrderDao;
use Silvanei\BranasCleanArchitecture\Application\Query\GetOrder;
use Silvanei\BranasCleanArchitecture\Application\Query\GetOrders;
use Silvanei\BranasCleanArchitecture\Application\UseCase\PlaceOrder\PlaceOrder;
use Silvanei\BranasCleanArchitecture\Application\UseCase\SimulateFreight\SimulateFreight;
use Silvanei\BranasCleanArchitecture\Application\UseCase\ValidateCoupon\ValidateCoupon;
use Silvanei\BranasCleanArchitecture\Domain\Entity\DefaultFreightCalculator;
use Silvanei\BranasCleanArchitecture\Domain\Entity\FreightCaculator;
use Silvanei\BranasCleanArchitecture\Domain\Repository\CouponRepository;
use Silvanei\BranasCleanArchitecture\Domain\Repository\ItemRepository;
use Silvanei\BranasCleanArchitecture\Domain\Repository\OrderRepository;
use Silvanei\BranasCleanArchitecture\Infra\Command\PlaceOrderCommand;
use Silvanei\BranasCleanArchitecture\Infra\Dao\OrderDaoDatabase;
use Silvanei\BranasCleanArchitecture\Infra\Database\PDOConnectionFactory;
use Silvanei\BranasCleanArchitecture\Infra\Http\Action\GetOrderAction;
use Silvanei\BranasCleanArchitecture\Infra\Http\Action\PlaceOrderAction;
use Silvanei\BranasCleanArchitecture\Infra\Http\Action\SimulateFreightAction;
use Silvanei\BranasCleanArchitecture\Infra\Http\Action\ValidateCouponAction;
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
        ],
        'invokables' => [
        ],
        'factories' => [
            PDO::class => PDOConnectionFactory::class,
            DefaultFreightCalculator::class => ReflectionBasedAbstractFactory::class,
            ItemRepositoryDatabase::class => ReflectionBasedAbstractFactory::class,
            SimulateFreight::class => ReflectionBasedAbstractFactory::class,

            CouponRepositoryDatabase::class => ReflectionBasedAbstractFactory::class,
            ValidateCoupon::class => ReflectionBasedAbstractFactory::class,

            OrderRepositoryDatabase::class => ReflectionBasedAbstractFactory::class,
            PlaceOrder::class => ReflectionBasedAbstractFactory::class,

            SimulateFreightAction::class => ReflectionBasedAbstractFactory::class,
            ValidateCouponAction::class => ReflectionBasedAbstractFactory::class,
            PlaceOrderAction::class => ReflectionBasedAbstractFactory::class,

            OrderDaoDatabase::class => ReflectionBasedAbstractFactory::class,
            GetOrder::class => ReflectionBasedAbstractFactory::class,
            GetOrders::class => ReflectionBasedAbstractFactory::class,
            GetOrderAction::class => ReflectionBasedAbstractFactory::class,

            PlaceOrderCommand::class => ReflectionBasedAbstractFactory::class,
        ],
    ],
];
