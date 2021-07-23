<?php

declare(strict_types=1);

namespace Zorachka\Application\QueryBus;

interface QueryBus
{
    /**
     * Fetch query.
     * @param object $query
     * @return object
     */
    public function fetch(object $query): object;
}
