<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Http;

final class Config
{
    private array $config;

    public function __invoke(): array
    {
        return [
            'config' => [
                'foundation' => $this->config,
            ],
        ];
    }

    public static function withDefaults(): self
    {
        $self = new self();
        $self->config = [
            'root_path' => null,
        ];

        return $self;
    }

    public function withRootPath(string $rootPath): self
    {
        $new = clone $this;
        $new->config['root_path'] = $rootPath;

        return $new;
    }
}
