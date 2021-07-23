<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Database\Cycle\Migrations\Console\Migration;

use Cycle\Migrations\MigrationImage;
use Psr\EventDispatcher\EventDispatcherInterface;
use Spiral\Database\Database;
use Spiral\Database\DatabaseProviderInterface;
use Spiral\Migrations\Config\MigrationConfig;
use Spiral\Migrations\Exception\RepositoryException;
use Spiral\Migrations\MigrationInterface;
use Spiral\Migrations\Migrator;
use Spiral\Migrations\State;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

abstract class BaseMigrationCommand extends Command
{
    protected const MIGRATION_STATUS = [
        State::STATUS_UNDEFINED => 'undefined',
        State::STATUS_PENDING => 'pending',
        State::STATUS_EXECUTED => 'executed',
    ];
    protected DatabaseProviderInterface $databaseProvider;
    protected Database $database;
    protected MigrationConfig $migrationConfig;
    protected Migrator $migrator;
    protected EventDispatcherInterface $eventDispatcher;

    public function __construct(
        DatabaseProviderInterface $databaseProvider,
        Database $database,
        MigrationConfig $migrationConfig,
        Migrator $migrator,
        EventDispatcherInterface $eventDispatcher,
    ) {
        $this->databaseProvider = $databaseProvider;
        $this->database = $database;
        $this->migrationConfig = $migrationConfig;
        $this->migrator = $migrator;
        $this->eventDispatcher = $eventDispatcher;
        parent::__construct();
    }

    protected function createEmptyMigration(
        OutputInterface $output,
        string $name,
        ?string $database = null
    ): ?MigrationImage {
        if ($database === null) {
            // get default database
            $database = $this->database->getName();
        }
        $migrator = $this->migrator;

        $migrationSkeleton = new MigrationImage($this->migrationConfig, $database);
        $migrationSkeleton->setName($name);
        try {
            $migrationFile = $migrator->getRepository()->registerMigration(
                $migrationSkeleton->buildFileName(),
                $migrationSkeleton->getClass()->getName(),
                $migrationSkeleton->getFile()->render()
            );
        } catch (RepositoryException $e) {
            $output->writeln('<fg=yellow>Can not create migration</>');
            $output->writeln('<fg=red>' . $e->getMessage() . '</>');
            return null;
        }
        $output->writeln('<info>New migration file has been created</info>');
        $output->writeln("<fg=cyan>{$migrationFile}</>");
        return $migrationSkeleton;
    }

    /**
     * @param OutputInterface $output
     *
     * @return MigrationInterface[]
     */
    protected function findMigrations(OutputInterface $output): array
    {
        $list = $this->migrator->getMigrations();
        $output->writeln(
            sprintf(
                '<info>Total %d migration(s) found in %s</info>',
                count($list),
                $this->migrationConfig->getDirectory()
            )
        );
        return $list;
    }
}
