<?php

declare(strict_types=1);

namespace Zorachka\Framework\Logger;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Zorachka\Framework\Container\ServiceProvider;

final class LoggerServiceProvider implements ServiceProvider
{
    /**
     * @inheritDoc
     */
    public static function getDefinitions(): array
    {
        return [
            LoggerInterface::class => function (ContainerInterface $container) {
                /** @var LoggerConfig $logger */
                $config = $container->get(LoggerConfig::class);

                $level = $config->debug() ? Logger::DEBUG : Logger::INFO;

                $monolog = new Logger($config->name());

                if ($config->stderr()) {
                    $monolog->pushHandler(new StreamHandler('php://stderr', $level));
                }

                if (!empty($config->file())) {
                    $monolog->pushHandler(new StreamHandler($config->file(), $level));
                }

                return $monolog;
            },
            LoggerConfig::class => fn() => LoggerConfig::withDefaults(),
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
