<?php

declare(strict_types=1);

namespace Zorachka\Application\QueryBus;

interface QueryBus
{
    /**
     * Fetch query.
     * @param object $query
     * @return object|object[]|null
     */
    public function fetch(object $query): object|array|null;
}
