<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Clock;

use DateTimeZone;
use Psr\Container\ContainerInterface;
use Zorachka\Contracts\Application\Clock\Clock;

final class ConfigProvider
{
    public function __invoke(): array
    {
        $config = Config::defaults();
        $defaults = $config();

        return [
            Clock::class => static function (ContainerInterface $container) {
                $config = $container->has('config') ? $container->get('config') : [];
                $clock = $config['clock'] ?? [];

                return new TimeZoneAwareClock(new DateTimeZone($clock['timezone']));
            },
            'config' => $defaults['config'],
        ];
    }
}
