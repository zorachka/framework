<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Templer;

final class Config
{
    private array $config;

    public function build(): array
    {
        return [
            'config' => [
                'templer' => $this->config,
            ],
        ];
    }

    public static function withDefaults(): self
    {
        $self = new self();
        $self->config = [
            'templates_dir' => 'app/templates/',
            'cache_dir' => 'var/cache/twig/',
            'debug' => false,
        ];

        return $self;
    }

    public function withTemplatesDir(string $templatesDir): self
    {
        $new = clone $this;
        $new->config['templates_dir'] = $templatesDir;

        return $new;
    }

    public function withCacheDir(string $cacheDir): self
    {
        $new = clone $this;
        $new->config['cache_dir'] = $cacheDir;

        return $new;
    }

    public function withDebug(bool $isEnabled): self
    {
        $new = clone $this;
        $new->config['debug'] = $isEnabled;

        return $new;
    }
}
