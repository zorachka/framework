<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\ExceptionHandler;

use Psr\Container\ContainerInterface;
use Sentry\SentrySdk;
use Zorachka\Contracts\Application\ExceptionHandler\ExceptionHandler;

final class ConfigProvider
{
    public function __invoke(): array
    {
        $defaultConfig = Config::defaults();
        $defaults = $defaultConfig();

        return [
            ExceptionHandler::class => static function (ContainerInterface $container) {
                $config = $container->has('config') ? $container->get('config') : [];
                $exceptionHandler = $config['exception_handler'] ?? [];

                return new SentryExceptionHandler(
                    SentrySdk::getCurrentHub(),
                    $exceptionHandler['dsn'],
                    $exceptionHandler['is_enabled'],
                );
            },
            'config' => $defaults['config'],
        ];
    }
}
