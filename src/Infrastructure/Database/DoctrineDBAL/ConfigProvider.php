<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Database\DoctrineDBAL;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Psr\Container\ContainerInterface;
use Zorachka\Contracts\Application\Database\Transaction\Transaction;
use Zorachka\Infrastructure\Database\DoctrineDBAL\Transaction\DBALTransaction;

final class ConfigProvider
{
    public function __invoke(): array
    {
        $defaultConfig = Config::defaults();
        $defaults = $defaultConfig();

        return [
            Connection::class => function (ContainerInterface $container): Connection {
                $config = $container->has('config') ? $container->get('config') : [];
                $dbal = $config['dbal'] ?? [];

                $connectionParams = $dbal['connection'] ?? [];

                return DriverManager::getConnection($connectionParams);
            },
            Transaction::class => static function (ContainerInterface $container) {
                /** @var Connection $connection */
                $connection = $container->get(Connection::class);

                return new DBALTransaction($connection);
            },

            'config' => $defaults['config'],
        ];
    }
}
