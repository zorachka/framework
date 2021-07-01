<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Database\Migrations;

use Doctrine\DBAL\Connection;
use Doctrine\Migrations;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Tools\Console\Command;
use Psr\Container\ContainerInterface;
use Doctrine\Migrations\Provider\SchemaProvider;
use Zorachka\Infrastructure\Database\Migrations\Schema\AggregateSchemaProvider;

final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            SchemaProvider::class => static function (ContainerInterface $container) {
                $config = $container->get('config')['migrations'];

                return new AggregateSchemaProvider($config['schemas']);
            },
            DependencyFactory::class => static function (ContainerInterface $container) {
                $config = $container->get('config')['migrations'];

                $configuration = new Configuration();
                $configuration->addMigrationsDirectory('DoctrineMigrations', $config['path']);
                $configuration->setAllOrNothing(true);
                $configuration->setCheckDatabasePlatform(false);

                $storageConfiguration = new Migrations\Metadata\Storage\TableMetadataStorageConfiguration();
                $storageConfiguration->setTableName('migrations');

                $configuration->setMetadataStorageConfiguration($storageConfiguration);

                $connection = $container->get(Connection::class);
                $factory = DependencyFactory::fromConnection(
                    new Migrations\Configuration\Migration\ExistingConfiguration($configuration),
                    new Migrations\Configuration\Connection\ExistingConnection($connection)
                );

                $schemaProvider = $container->get(SchemaProvider::class);

                $factory->setService(Migrations\Provider\SchemaProvider::class, $schemaProvider);

                return $factory;
            },
            // Commands
            Command\ExecuteCommand::class => static function (ContainerInterface $container) {
                /** @var DependencyFactory $factory */
                $factory = $container->get(DependencyFactory::class);
                return new Command\ExecuteCommand($factory);
            },
            Command\MigrateCommand::class => static function (ContainerInterface $container) {
                /** @var DependencyFactory $factory */
                $factory = $container->get(DependencyFactory::class);
                return new Command\MigrateCommand($factory);
            },
            Command\LatestCommand::class => static function (ContainerInterface $container) {
                /** @var DependencyFactory $factory */
                $factory = $container->get(DependencyFactory::class);
                return new Command\LatestCommand($factory);
            },
            Command\ListCommand::class => static function (ContainerInterface $container) {
                /** @var DependencyFactory $factory */
                $factory = $container->get(DependencyFactory::class);
                return new Command\ListCommand($factory);
            },
            Command\StatusCommand::class => static function (ContainerInterface $container) {
                /** @var DependencyFactory $factory */
                $factory = $container->get(DependencyFactory::class);
                return new Command\StatusCommand($factory);
            },
            Command\UpToDateCommand::class => static function (ContainerInterface $container) {
                /** @var DependencyFactory $factory */
                $factory = $container->get(DependencyFactory::class);
                return new Command\UpToDateCommand($factory);
            },
            Command\DiffCommand::class => static function (ContainerInterface $container) {
                /** @var DependencyFactory $factory */
                $factory = $container->get(DependencyFactory::class);
                return new Command\DiffCommand($factory);
            },
//    Command\GenerateCommand::class => static function (ContainerInterface $container) {
//        /** @var DependencyFactory $factory */
//        $factory = $container->get(DependencyFactory::class);
//        return new Command\GenerateCommand($factory);
//    },

            'config' => [
                'migrations' => [
                    'path' => __DIR__ . '/../../migrations',
                    'schemas' => [
                        // list all the aggregate class names of your application, e.g.
                    ],
                ],
                'console' => [
                    'commands' => [
                        Migrations\Tools\Console\Command\ExecuteCommand::class,
                        Migrations\Tools\Console\Command\MigrateCommand::class,
                        Migrations\Tools\Console\Command\LatestCommand::class,
                        Migrations\Tools\Console\Command\ListCommand::class,
                        Migrations\Tools\Console\Command\StatusCommand::class,
                        Migrations\Tools\Console\Command\UpToDateCommand::class,
                        Migrations\Tools\Console\Command\DiffCommand::class,
//                Migrations\Tools\Console\Command\GenerateCommand::class,
                    ],
                ],
            ]
        ];
    }
}
