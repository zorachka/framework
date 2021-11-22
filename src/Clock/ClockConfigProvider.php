<?php

declare(strict_types=1);

namespace Zorachka\Framework\Clock;

use DateTimeZone;
use Psr\Container\ContainerInterface;
use Zorachka\Framework\Container\ServiceProvider;

final class ClockConfigProvider implements ServiceProvider
{
    /**
     * @inheritDoc
     */
    public static function getDefinitions(): array
    {
        return [
            ClockInterface::class => static function (ContainerInterface $container) {
                /** @var ClockConfig $config */
                $config = $container->get(ClockConfig::class);

                return new TimeZoneAwareClock(new DateTimeZone($config->timezone()));
            },
            ClockConfig::class => fn() => ClockConfig::withDefaults(),
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
