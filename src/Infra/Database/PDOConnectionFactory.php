<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Database;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use PDO;

final class PDOConnectionFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): PDO
    {
        /** @var array<string> $config */
        $config = $container->get('config');

        if (! isset($config['db'])) {
            throw new ServiceNotCreatedException('Informar conexão com o banco');
        }

        /** @var array{"dsn": string, "username": string, "password": string, "driver_options": array<int, int>} $conn */
        $conn = $config['db'];
        return new PDO(
            $conn['dsn'],
            $conn['username'],
            $conn['password'],
            $conn['driver_options']
        );
    }
}
