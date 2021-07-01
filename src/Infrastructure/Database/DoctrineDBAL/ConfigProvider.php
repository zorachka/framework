<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Database\DoctrineDBAL;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Psr\Container\ContainerInterface;
use Zorachka\Contracts\Application\Database\Transaction\Transaction;
use Zorachka\Infrastructure\Database\Transaction\DBALTransaction;

use function Zorachka\Foundation\env;

final class ConfigProvider
{
    public function __invoke(): array
    {
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

            'config' => [
                'dbal' => [
                    'connection' => [
                        'driver' => env('DB_DRIVER'),
                        'host' => env('DB_HOST'),
                        'user' => env('DB_USER'),
                        'password' => env('DB_PASSWORD'),
                        'dbname' => env('DB_NAME'),
                        'charset' => 'utf-8'
                    ],
                ],
            ]
        ];
    }
}
