<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\QueryBus;

final class QueryBusFetchersRegistry implements FetchersRegistry
{
    private array $handlersMap;

    public function setupFetcherForQuery(string $queryClassName, callable $fetcher): void
    {
        $this->handlersMap[$queryClassName] = $fetcher;
    }

    public function getFetcherForQuery(string $queryClassName): callable
    {
        return $this->handlersMap[$queryClassName];
    }
}
