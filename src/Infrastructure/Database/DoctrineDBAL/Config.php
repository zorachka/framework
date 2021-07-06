<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Database\DoctrineDBAL;

use function Zorachka\Application\Support\env;

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
                'dbal' => $this->config
            ],
        ];
    }

    public static function defaults(): self
    {
        $self = new self();
        $self->config = [
            'connection' => [
                'driver' => env('DB_DRIVER'),
                'host' => env('DB_HOST'),
                'user' => env('DB_USER'),
                'password' => env('DB_PASSWORD'),
                'dbname' => env('DB_NAME'),
                'charset' => 'utf-8'
            ],
        ];

        return $self;
    }

    public function driver(string $driver): self
    {
        $this->config['connection']['driver'] = $driver;

        return $this;
    }

    public function host(string $host): self
    {
        $this->config['connection']['host'] = $host;

        return $this;
    }

    public function user(string $user): self
    {
        $this->config['connection']['user'] = $user;

        return $this;
    }

    public function password(string $password): self
    {
        $this->config['connection']['password'] = $password;

        return $this;
    }

    public function databaseName(string $databaseName): self
    {
        $this->config['connection']['dbname'] = $databaseName;

        return $this;
    }

    public function charset(string $charset): self
    {
        $this->config['connection']['charset'] = $charset;

        return $this;
    }
}
