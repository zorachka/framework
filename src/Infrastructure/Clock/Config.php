<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Clock;

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
                'clock' => $this->config,
            ],
        ];
    }

    public static function defaults(): self
    {
        $self = new self();
        $self->config = [
            'timezone' => 'UTC',
        ];

        return $self;
    }

    public function timezone(string $timezone): self
    {
        $new = clone $this;
        $new->config['timezone'] = $timezone;

        return $new;
    }
}
