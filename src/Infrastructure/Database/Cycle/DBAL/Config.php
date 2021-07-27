<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Database\Cycle\DBAL;

use Spiral\Database\Driver;
use Zorachka\Application\Support\Env;

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
                'database' => $this->config,
            ],
        ];
    }

    public static function withDefaults(): self
    {
        $self = new self();
        $self->config = [
            'default' => 'default',
            'databases' => [
                'default' => ['connection' => 'postgres'],
            ],
            'connections' => [
                'postgres' => [
                    'driver' => Driver\Postgres\PostgresDriver::class,
                    'options' => [
                        'connection' => 'pgsql:host=' . Env::get('DB_HOST') . ';dbname=' . Env::get('DB_NAME'),
                        'username' => Env::get('DB_USERNAME'),
                        'password' => Env::get('DB_PASSWORD'),
                    ]
                ],
            ]
        ];

        return $self;
    }

    public function addDatabase(
        string $host,
        string $name,
        string $username,
        string $password,
    ): self {
        $new = clone $this;
        $new->config['databases'][$name] = ['connection' => $name];
        $new->config['connections'][$name] = [
            'driver' => Driver\Postgres\PostgresDriver::class,
            'options' => [
                'connection' => 'pgsql:host=' . $host . ';dbname=' . $name,
                'username' => $username,
                'password' => $password,
            ]
        ];

        return $new;
    }
}
