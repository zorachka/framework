<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\ExceptionHandler;

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
                'exception_handler' => $this->config,
            ],
        ];
    }

    public static function defaults(): self
    {
        $self = new self();
        $self->config = [
            'dsn' => env('SENTRY_DSN'),
            'is_enabled' => env('SENTRY_DSN') !== '',
        ];

        return $self;
    }

    public function dsn(string $dsn): self
    {
        $new = clone $this;
        $new->config['dsn'] = $dsn;

        return $new;
    }

    public function isEnabled(bool $isEnabled): self
    {
        $new = clone $this;
        $new->config['is_enabled'] = $isEnabled;

        return $new;
    }
}
