<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\QueryBus;

interface FetchersRegistry
{
    /**
     * @param string $queryClassName
     * @param callable $fetcher
     */
    public function setupFetcherForQuery(string $queryClassName, callable $fetcher): void;

    /**
     * @param string $queryClassName
     * @return callable
     */
    public function getFetcherForQuery(string $queryClassName): callable;
}
