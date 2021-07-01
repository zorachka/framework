<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\ExceptionHandler;

use Sentry\State\HubInterface;
use Throwable;
use Zorachka\Contracts\Application\ExceptionHandler\ExceptionHandler;

final class SentryExceptionHandler implements ExceptionHandler
{
    private HubInterface $hub;

    public function __construct(HubInterface $hub)
    {
        $this->hub = $hub;
    }

    public function capture(Throwable $exception): void
    {
        $this->hub->captureException($exception);
    }
}
