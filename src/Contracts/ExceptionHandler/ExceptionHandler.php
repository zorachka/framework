<?php

declare(strict_types=1);

namespace Zorachka\Contracts\ExceptionHandler;

use Throwable;

interface ExceptionHandler
{
    public function capture(Throwable $exception): void;
}
