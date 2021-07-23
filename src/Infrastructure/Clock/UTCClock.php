<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Clock;

use DateTimeZone;
use DateTimeImmutable;
use Zorachka\Application\Clock\ClockInterface;

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
