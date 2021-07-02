<?php

declare(strict_types=1);

namespace Zorachka\Contracts\Application\ExceptionHandler;

use Throwable;

interface ExceptionHandler
{
    public function init(): void;

    public function capture(Throwable $exception): void;
}
