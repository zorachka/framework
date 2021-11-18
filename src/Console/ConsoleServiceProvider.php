<?php

declare(strict_types=1);

namespace Zorachka\Framework\Console;

use Psr\Container\ContainerInterface;
use Zorachka\Framework\Container\ServiceProvider;

final class ConsoleServiceProvider implements ServiceProvider
{
    /**
     * @inheritDoc
     */
    public static function getDefinitions(): array
    {
        return [
            Application::class => static function(ContainerInterface $container) {
                /** @var ConsoleConfig $config */
                $config = $container->get(ConsoleConfig::class);
                $commands = [];

                foreach ($config->commands() as $commandClassName) {
                    $commands[] = $container->get($commandClassName);
                }

                return new ConsoleApplication(
                    $config->appName(),
                    $config->catchExceptions(),
                    $commands,
                );
            },
            ConsoleConfig::class => ConsoleConfig::withDefaults(),
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
