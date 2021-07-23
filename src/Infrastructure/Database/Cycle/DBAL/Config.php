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

    public function __invoke(): array
    {
        return [
            'config' => [
                'database' => $this->config,
            ],
        ];
    }

    public static function defaults(): self
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
}
