<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Console;

use Psr\Container\ContainerInterface;
use Zorachka\Infrastructure\Console\Command\ClearCacheCommand;

final class ConfigProvider
{
    public function __invoke(): array
    {
        $defaultConfig = Config::withDefaults()
            ->withCommand(ClearCacheCommand::class);
        $defaults = $defaultConfig->build();

        return [
            Application::class => static function (ContainerInterface $container) {
                $config = $container->has('config') ? $container->get('config') : [];
                $console = $config['console'] ?? [];

                $appName = $console['app_name'];
                $catchExceptions = $console['catch_exceptions'];

                $commands = [];
                foreach ($console['commands'] as $commandClassName) {
                    $commands[] = $container->get($commandClassName);
                }

                return new ConsoleApplication($appName, $catchExceptions, $commands);
            },
            'config' => $defaults['config'],
        ];
    }
}
