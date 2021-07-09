<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\CommandBus\Onliner\Middleware;

use Doctrine\DBAL\Connection;
use League\Event\BufferedEventDispatcher;
use Onliner\CommandBus\Context;
use Onliner\CommandBus\Middleware;
use Psr\EventDispatcher\EventDispatcherInterface;

final class ReleaseRecordedEventsMiddleware implements Middleware
{
    private EventDispatcherInterface $dispatcher;
    private BufferedEventDispatcher $bufferedEventDispatcher;
    private Connection $connection;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        BufferedEventDispatcher $bufferedEventDispatcher,
        Connection $connection
    ) {
        $this->dispatcher = $dispatcher;
        $this->bufferedEventDispatcher = $bufferedEventDispatcher;
        $this->connection = $connection;
    }

    /**
     * @inheritDoc
     */
    public function call(object $message, Context $context, callable $next): void
    {
        try {
            $next($message, $context);
        } catch (\Exception $exception) {
            // Erase events
            throw $exception;
        }

        $this->bufferedEventDispatcher->dispatchBufferedEvents();
    }
}
