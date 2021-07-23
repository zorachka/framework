<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Database\Doctrine\Migrations;

use Psr\Container\ContainerInterface;
use Doctrine\DBAL\Connection;
use Doctrine\Migrations;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Tools\Console\Command;
use Doctrine\Migrations\Provider\SchemaProvider;
use Zorachka\Infrastructure\Database\Doctrine\Migrations\Schema\AggregateSchemaProvider;

final class ConfigProvider
{
    public function __invoke(): array
    {
        $defaultConfig = Config::defaults();
        $defaults = $defaultConfig();

        return [
            SchemaProvider::class => static function (ContainerInterface $container) {
                $config = $container->has('config') ? $container->get('config') : [];
                $migrations = $config['migrations'] ?? [];

                return new AggregateSchemaProvider($migrations['schemas']);
            },
            DependencyFactory::class => static function (ContainerInterface $container) {
                $config = $container->has('config') ? $container->get('config') : [];
                $migrations = $config['migrations'] ?? [];

                $foundation = $config['foundation'] ?? [];

                $configuration = new Configuration();
                $migrationsDirectory = \realpath($foundation['root_path'] . '/' . $migrations['path']);
                $configuration->addMigrationsDirectory(
                    'DoctrineMigrations',
                    $migrationsDirectory,
                );
                $configuration->setAllOrNothing(true);
                $configuration->setCheckDatabasePlatform(false);

                $storageConfiguration = new Migrations\Metadata\Storage\TableMetadataStorageConfiguration();
                $storageConfiguration->setTableName($migrations['table_name']);

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
            // Command
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
            'config' => $defaults['config'],
        ];
    }
}
