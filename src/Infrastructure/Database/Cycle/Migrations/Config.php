<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Database\Cycle\Migrations;

use Zorachka\Infrastructure\Database\Cycle\Migrations\Console\Migration\CreateCommand;
use Zorachka\Infrastructure\Database\Cycle\Migrations\Console\Migration\DownCommand;
use Zorachka\Infrastructure\Database\Cycle\Migrations\Console\Migration\GenerateCommand;
use Zorachka\Infrastructure\Database\Cycle\Migrations\Console\Migration\ListCommand;
use Zorachka\Infrastructure\Database\Cycle\Migrations\Console\Migration\UpCommand;

final class Config
{
    private array $config;

    private function __construct()
    {
    }

    public function __invoke(): array
    {
        return [
            'config' => [
                'migrations' => $this->config,
                'console' => [
                    'commands' => [
                        CreateCommand::class,
                        GenerateCommand::class,
                        ListCommand::class,
                        UpCommand::class,
                        DownCommand::class,
                    ]
                ],
            ],
        ];
    }

    public static function defaults(): self
    {
        $self = new self();
        $self->config = [
            // directory to store migration files
            'directory' => 'app/migrations',

            // Table name to store information about migrations status
            // (per database)
            'table' => 'migrations',

            // When set to true no confirmation
            // will be requested on migration run.
            'safe' => false,
        ];

        return $self;
    }
}
