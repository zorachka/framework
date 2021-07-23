<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Console;

use Zorachka\Infrastructure\Console\Command\ClearCacheCommand;

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
                'console' => $this->config,
            ]
        ];
    }

    public static function withDefaults(): self
    {
        $self = new self();
        $self->config = [
            'app_name' => 'Console App',
            'catch_exceptions' => false,
            'commands' => [
                ClearCacheCommand::class,
            ],
        ];

        return $self;
    }

    public function withAppName(string $appName): self
    {
        $new = clone $this;
        $new->config['app_name'] = $appName;

        return $new;
    }

    public function withCatchExceptions(bool $isEnabled): self
    {
        $new = clone $this;
        $new->config['catch_exceptions'] = $isEnabled;

        return $new;
    }

    /**
     * @param string $command Class name
     * @return $this
     */
    public function withCommand(string $command): self
    {
        $new = clone $this;
        $new->config['commands'][] = $command;

        return $new;
    }
}
