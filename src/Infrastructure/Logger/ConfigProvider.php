<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Logger;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use function Zorachka\Foundation\env;

final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            LoggerInterface::class => function (ContainerInterface $container) {
                /**
                 * @psalm-suppress MixedArrayAccess
                 * @psalm-var array{
                 *     debug:bool,
                 *     stderr:bool,
                 *     file:string
                 * } $config
                 */
                $config = $container->get('config')['logger'];

                $level = $config['debug'] ? Logger::DEBUG : Logger::INFO;

                $log = new Logger(env('APP_NAME'));

                if ($config['stderr']) {
                    $log->pushHandler(new StreamHandler('php://stderr', $level));
                }

                if (!empty($config['file'])) {
                    $log->pushHandler(new StreamHandler($config['file'], $level));
                }

                return $log;
            },

            'config' => [
                'logger' => [
                    'debug' => env('APP_DEBUG'),
                    'file' => null,
                    'stderr' => true,
                ],
            ],
        ];
    }
}
