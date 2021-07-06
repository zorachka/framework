<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Console;

use Psr\Container\ContainerInterface;

final class ConfigProvider
{
    public function __invoke(): array
    {
        $defaultConfig = Config::defaults();
        $defaults = $defaultConfig();

        return [
            \Zorachka\Contracts\Console\Application::class => static function (ContainerInterface $container) {
                $config = $container->has('config') ? $container->get('config') : [];
                $console = $config['console'] ?? [];

                $appName = $console['app_name'];
                $catchExceptions = $console['catch_exceptions'];

                $commands = [];
                foreach ($console['commands'] as $commandClassName) {
                    $commands[] = $container->get($commandClassName);
                }

                return new Application($appName, $catchExceptions, $commands);
            },
            'config' => $defaults['config'],
        ];
    }
}
