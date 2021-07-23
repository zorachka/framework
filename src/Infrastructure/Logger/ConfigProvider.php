<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Logger;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

final class ConfigProvider
{
    public function __invoke(): array
    {
        $defaultConfig = Config::withDefaults();
        $defaults = $defaultConfig->build();

        return [
            LoggerInterface::class => function (ContainerInterface $container) {
                $config = $container->has('config') ? $container->get('config') : [];
                $logger = $config['logger'] ?? [];

                $level = $logger['debug'] ? Logger::DEBUG : Logger::INFO;

                $monolog = new Logger($logger['name']);

                if ($logger['stderr']) {
                    $monolog->pushHandler(new StreamHandler('php://stderr', $level));
                }

                if (!empty($logger['file'])) {
                    $monolog->pushHandler(new StreamHandler($logger['file'], $level));
                }

                return $monolog;
            },

            'config' => $defaults['config'],
        ];
    }
}
