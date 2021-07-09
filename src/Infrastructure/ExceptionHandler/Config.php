<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\ExceptionHandler;

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
                'exception_handler' => $this->config,
            ],
        ];
    }

    public static function defaults(): self
    {
        $self = new self();
        $self->config = [
            'dsn' => Env::get('SENTRY_DSN'),
            'is_enabled' => Env::get('SENTRY_DSN') !== '',
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
