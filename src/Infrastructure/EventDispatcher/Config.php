<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\EventDispatcher;

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
                'events' => $this->config,
            ],
        ];
    }

    public static function defaults(): self
    {
        $self = new self();
        $self->config = [];

        return $self;
    }

    /**
     * @param string $eventIdentifier
     * @param string $eventListener
     * @param int $priority
     * @return $this
     */
    public function addListener(string $eventIdentifier, string $eventListener, int $priority = 0): self
    {
        $new = clone $this;
        $new->config[$eventIdentifier][] = [$eventListener, $priority];

        return $new;
    }
}
