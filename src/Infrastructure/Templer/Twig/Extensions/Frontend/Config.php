<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Templer\Twig\Extensions\Frontend;

use function Zorachka\Application\Support\env;

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
                'frontend' => $this->config,
            ],
        ];
    }

    public static function defaults(): self
    {
        $self = new self();
        $self->config = [
            'url' => env('FRONTEND_URL')
        ];

        return $self;
    }

    public function url(string $url): self
    {
        $new = clone $this;
        $new->config['url'] = $url;

        return $new;
    }
}
