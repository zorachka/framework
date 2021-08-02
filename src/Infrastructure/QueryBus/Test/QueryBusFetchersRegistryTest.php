<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\QueryBus\Test;

use PHPUnit\Framework\TestCase;
use Zorachka\Infrastructure\QueryBus\QueryBusFetchersRegistry;

final class QueryBusFetchersRegistryTest extends TestCase
{
    public function testSetupFetcher()
    {
        $registry = new QueryBusFetchersRegistry();
        $registry->setupFetcherForQuery(Query::class, new Fetcher());
        $registry->setupFetcherForQuery(AnotherQuery::class, new AnotherFetcher());

        self::assertInstanceOf(Fetcher::class, $registry->getFetcherForQuery(Query::class));
        self::assertInstanceOf(AnotherFetcher::class, $registry->getFetcherForQuery(AnotherQuery::class));
    }
}
