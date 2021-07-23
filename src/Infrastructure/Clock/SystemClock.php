<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Clock;

use DateTimeImmutable;
use Zorachka\Application\Clock\ClockInterface;

final class SystemClock implements ClockInterface
{
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
