<?php

declare(strict_types=1);

namespace Zorachka\Framework\Clock;

use Exception;
use DateTimeZone;
use DateTimeImmutable;

final class TimeZoneAwareClock implements ClockInterface
{
    private DateTimeZone $timezone;

    public function __construct(DateTimeZone $timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * @throws Exception
     */
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable('now', $this->timezone);
    }
}
