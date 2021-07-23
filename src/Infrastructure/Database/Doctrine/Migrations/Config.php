<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Database\Doctrine\Migrations;

use Doctrine\Migrations;

final class Config
{
    private array $config;

    private function __construct()
    {
    }

    public function build(): array
    {
        return [
            'config' => [
                'migrations' => $this->config,
                'console' => [
                    'commands' => [
                        Migrations\Tools\Console\Command\ExecuteCommand::class,
                        Migrations\Tools\Console\Command\MigrateCommand::class,
                        Migrations\Tools\Console\Command\LatestCommand::class,
                        Migrations\Tools\Console\Command\ListCommand::class,
                        Migrations\Tools\Console\Command\StatusCommand::class,
                        Migrations\Tools\Console\Command\UpToDateCommand::class,
                        Migrations\Tools\Console\Command\DiffCommand::class,
                    ],
                ],
            ],
        ];
    }

    public static function defaults(): self
    {
        $self = new self();
        $self->config = [
            'table_name' => 'migrations',
            'path' => 'app/migrations',
            'schemas' => [
                // list all the aggregate class names of your application, e.g.
            ],
        ];

        return $self;
    }

    public function tableName(string $tableName): self
    {
        $new = clone $this;
        $new->config['table_name'] = $tableName;

        return $new;
    }

    public function path(string $tableName): self
    {
        $new = clone $this;
        $new->config['path'] = $tableName;

        return $new;
    }

    public function addSchema(string $schemaClassName): self
    {
        $new = clone $this;
        $new->config['schemas'][] = $schemaClassName;

        return $new;
    }
}
