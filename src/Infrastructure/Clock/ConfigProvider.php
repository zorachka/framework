<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Clock;

use DateTimeZone;
use Psr\Container\ContainerInterface;
use Zorachka\Contracts\Application\Clock\Clock;

use function Zorachka\Foundation\env;

final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            Clock::class => static function (ContainerInterface $container) {
                $config = $container->has('config') ? $container->get('config') : [];
                $clock = $config['clock'] ?? [];

                return new TimeZoneAwareClock(new DateTimeZone($clock['timezone']));
            },

            'config' => [
                'clock' => [
                    'timezone' => env('APP_TIMEZONE')
                ],
            ],
        ];
    }
}
