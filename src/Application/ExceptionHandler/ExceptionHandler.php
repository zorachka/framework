<?php

declare(strict_types=1);

namespace Zorachka\Application\ExceptionHandler;

use Throwable;

interface ExceptionHandler
{
    /**
     * Initialize exception handler
     */
    public function init(): void;

    /**
     * Capture exceptions with stacktrace to hub
     * @param Throwable $exception
     */
    public function capture(Throwable $exception): void;
}
