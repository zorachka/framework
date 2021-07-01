<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Clock;

use DateTimeImmutable;
use Zorachka\Contracts\Application\Clock\Clock;

final class SystemClock implements Clock
{
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
