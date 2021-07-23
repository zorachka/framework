<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\CommandBus\Tactician;

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
                'command_bus' => $this->config,
            ],
        ];
    }

    public static function withDefaults(): self
    {
        $self = new self();
        $self->config = [
            'handlers_map' => [
                // Command::class => Handler::class,
            ],
        ];

        return $self;
    }

    public function withHandlerFor(string $commandClassName, string $handlerClassName): self
    {
        $new = clone $this;
        $new->config['handlers_map'][$commandClassName] = $handlerClassName;

        return $new;
    }
}
