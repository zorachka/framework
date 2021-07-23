<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Database\Cycle\Migrations;

use Psr\Container\ContainerInterface;
use Spiral\Database\DatabaseManager;
use Spiral\Database\DatabaseProviderInterface;
use Spiral\Migrations\Config\MigrationConfig;
use Spiral\Migrations\Migrator;
use Spiral\Migrations\FileRepository;

final class ConfigProvider
{
    public function __invoke(): array
    {
        $defaultConfig = Config::defaults();
        $defaults = $defaultConfig();

        return [
            MigrationConfig::class => static function (ContainerInterface $container) {
                $config = $container->has('config') ? $container->get('config') : [];
                $migrations = $config['migrations'] ?? [];

                return new MigrationConfig($migrations);
            },
            Migrator::class => static function (ContainerInterface $container) {
                /** @var MigrationConfig $config */
                $migrationConfig = $container->get(MigrationConfig::class);
                /** @var DatabaseManager $dbal */
                $dbal = $container->get(DatabaseProviderInterface::class);

                $migrator = new Migrator(
                    $migrationConfig,
                    $dbal,
                    new FileRepository($migrationConfig)
                );

                if (!$migrator->isConfigured()) {
                    $migrator->configure();
                }

                return $migrator;
            },
            'config' => $defaults['config'],
        ];
    }
}
