<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\QueryBus;

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
                'query_bus' => $this->config,
            ],
        ];
    }

    public static function defaults(): self
    {
        $self = new self();
        $self->config = [
            'fetchers_map' => [
                // Query::class => Fetcher::class
            ],
        ];

        return $self;
    }

    public function setupFetcherFor(string $queryClassName, string $fetcherClassName): self
    {
        $self = new self();
        $self->config['fetchers_map'][$queryClassName] = $fetcherClassName;

        return $self;
    }
}
