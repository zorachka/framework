<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Clock;

use DateTimeImmutable;
use Zorachka\Contracts\Application\Clock\Clock;

final class FrozenClock implements Clock
{
    private DateTimeImmutable $now;

    public function __construct(DateTimeImmutable $now)
    {
        $this->now = $now;
    }

    public function now(): DateTimeImmutable
    {
        return $this->now;
    }
}
