<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Clock;

use DateTimeImmutable;
use Zorachka\Application\Clock\ClockInterface;

final class FrozenClock implements ClockInterface
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
