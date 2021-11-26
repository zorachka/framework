<?php

declare(strict_types=1);

namespace Zorachka\Framework\UuidProvider;

use Ramsey\Uuid\Uuid;

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
