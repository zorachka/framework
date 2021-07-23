<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Database\Cycle\DBAL;

use Psr\Container\ContainerInterface;
use Spiral\Database;
use Zorachka\Application\Database\Transaction\Transaction;

final class ConfigProvider
{
    public function __invoke(): array
    {
        $defaultConfig = Config::withDefaults();
        $defaults = $defaultConfig();

        return [
            Transaction::class => static function (ContainerInterface $container) {
                /** @var Database\Database $database */
                $database = $container->get(Database\Database::class);

                return new CycleTransaction($database);
            },
            Database\Database::class => static function (ContainerInterface $container) {
                /** @var Database\DatabaseProviderInterface $manager */
                $manager = $container->get(Database\DatabaseProviderInterface::class);

                return $manager->database();
            },
            Database\DatabaseProviderInterface::class => static function (ContainerInterface $container) {
                $config = $container->has('config') ? $container->get('config') : [];
                $database = $config['database'] ?? [];

                return new Database\DatabaseManager(
                    new Database\Config\DatabaseConfig($database)
                );
            },
            'config' => $defaults['config'],
        ];
    }
}
