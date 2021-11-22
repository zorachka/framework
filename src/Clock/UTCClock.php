<?php

declare(strict_types=1);

namespace Zorachka\Framework\Clock;

use DateTimeZone;
use DateTimeImmutable;

final class UTCClock implements ClockInterface
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
