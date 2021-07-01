<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\ExceptionHandler;

use Sentry\SentrySdk;
use Zorachka\Contracts\Application\ExceptionHandler\ExceptionHandler;

final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            ExceptionHandler::class => static function () {
                return new SentryExceptionHandler(SentrySdk::getCurrentHub());
            },
        ];
    }
}
