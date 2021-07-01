<?php

declare(strict_types=1);

namespace Zorachka\Contracts\Clock;

use DateTimeImmutable;

interface Clock
{
    /**
     * Returns the current time as a DateTimeImmutable Object
     */
    public function now(): DateTimeImmutable;
}

