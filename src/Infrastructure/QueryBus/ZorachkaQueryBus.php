<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\QueryBus;

use Zorachka\Application\QueryBus\QueryBus;

final class ZorachkaQueryBus implements QueryBus
{
    private FetchersRegistry $registry;

    public function __construct(FetchersRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @inheritDoc
     */
    public function fetch(object $query): object
    {
        $fetcher = $this->registry->getFetcherForQuery(\get_class($query));

        return $fetcher($query);
    }
}
