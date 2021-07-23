<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Templer\Twig;

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
                'twig' => $this->config,
            ],
        ];
    }

    public static function withDefaults(): self
    {
        $self = new self();
        $self->config = [
            'extensions' => [],
        ];

        return $self;
    }

    public function withExtension(string $extension): self
    {
        $new = clone $this;
        $new->config['extensions'][] = $extension;

        return $new;
    }
}
