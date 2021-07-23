<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Templer\Twig\Extensions\Frontend;

use Zorachka\Application\Support\Env;

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
                'frontend' => $this->config,
            ],
        ];
    }

    public static function withDefaults(): self
    {
        $self = new self();
        $self->config = [
            'url' => Env::get('APP_URL')
        ];

        return $self;
    }

    public function withUrl(string $url): self
    {
        $new = clone $this;
        $new->config['url'] = $url;

        return $new;
    }
}
