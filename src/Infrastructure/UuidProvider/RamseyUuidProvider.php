<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\UuidProvider;

use Ramsey\Uuid\Uuid;
use Zorachka\Application\UuidProvider\UuidProvider;

final class RamseyUuidProvider implements UuidProvider
{
    /**
     * @inheritDoc
     */
    public static function next(): string
    {
        return Uuid::uuid4()->toString();
    }
}
