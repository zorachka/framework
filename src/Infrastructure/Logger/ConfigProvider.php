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
        $config = Config::defaults();
        $defaults = $config();

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
                    $rootPath = $container->get('config')['foundation']['root_path'];

                    $monolog->pushHandler(new StreamHandler(\realpath($rootPath . $logger['file']), $level));
                }

                return $monolog;
            },

            'config' => $defaults['config'],
        ];
    }
}
