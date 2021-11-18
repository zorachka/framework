<?php

declare(strict_types=1);

namespace Zorachka\Framework\Console;

final class ConsoleConfig
{
    private string $appName;
    private bool $catchExceptions;
    private array $commands;

    public function __construct(string $appName, bool $catchExceptions, array $commands)
    {
        $this->appName = $appName;
        $this->catchExceptions = $catchExceptions;
        $this->commands = $commands;
    }

    public static function withDefaults(
        string $appName = 'Console App',
        bool $catchExceptions = false,
        array $commands = []
    )
    {
        return new self($appName, $catchExceptions, $commands);
    }

    /**
     * @return string
     */
    public function appName(): string
    {
        return $this->appName;
    }

    public function withAppName(string $appName): self
    {
        $new = clone $this;
        $new->appName = $appName;

        return $new;
    }

    /**
     * @return bool
     */
    public function catchExceptions(): bool
    {
        return $this->catchExceptions;
    }

    /**
     * @return array
     */
    public function commands(): array
    {
        return $this->commands;
    }
}
