<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Clock;

use DateTimeImmutable;
use DateTimeZone;
use Zorachka\Contracts\Application\Clock\Clock;

final class UTCClock implements Clock
{
    private TimeZoneAwareClock $inner;

    public function __construct()
    {
        $this->inner = new TimeZoneAwareClock(new DateTimeZone('UTC'));
    }

    /**
     * @throws \Exception
     */
    public function now(): DateTimeImmutable
    {
        return $this->inner->now();
    }
}
