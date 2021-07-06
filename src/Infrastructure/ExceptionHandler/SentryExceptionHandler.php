<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\ExceptionHandler;

use Sentry\State\HubInterface;
use Throwable;
use Zorachka\Contracts\Application\ExceptionHandler\ExceptionHandler;

use function Sentry\init;

final class SentryExceptionHandler implements ExceptionHandler
{
    private HubInterface $hub;
    private string $dsn;
    private bool $isEnabled;

    public function __construct(HubInterface $hub, string $dsn, bool $isEnabled)
    {
        $this->hub = $hub;
        $this->isEnabled = $isEnabled;
        $this->dsn = $dsn;
    }

    public function init(): void
    {
        if ($this->isEnabled) {
            init(['dsn' => $this->dsn]);
        }
    }

    public function capture(Throwable $exception): void
    {
        $this->hub->captureException($exception);
    }
}
