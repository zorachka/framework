<?php

declare(strict_types=1);

namespace Zorachka\Framework\Clock;

use DateTimeImmutable;

final class SystemClock implements ClockInterface
{
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
