<?php

declare(strict_types=1);

namespace Zorachka\Application\Clock;

use DateTimeImmutable;

interface ClockInterface
{
    /**
     * Returns the current time as a DateTimeImmutable Object.
     * It's a Psr\Clock in future.
     */
    public function now(): DateTimeImmutable;
}

