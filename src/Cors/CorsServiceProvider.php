<?php

declare(strict_types=1);

namespace Zorachka\Framework\Cors;

use Zorachka\Framework\Container\ServiceProvider;

final class CorsServiceProvider implements ServiceProvider
{
    /**
     * @inheritDoc
     */
    public static function getDefinitions(): array
    {
        return [
            CorsConfig::class => fn() => CorsConfig::withDefaults(),
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
