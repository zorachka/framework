<?php

declare(strict_types=1);

namespace Zorachka\Framework\UuidProvider;

use Zorachka\Framework\Container\ServiceProvider;

final class UuidServiceProvider implements ServiceProvider
{
    /**
     * @inheritDoc
     */
    public static function getDefinitions(): array
    {
        return [
            UuidProvider::class => static fn() => new RamseyUuidProvider,
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getExtensions(): array
    {
        return [];
    }
}
