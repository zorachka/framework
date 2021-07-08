<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\CommandBus\Onliner\Middleware;

use Onliner\CommandBus\Context;
use Onliner\CommandBus\Middleware;
use Psr\EventDispatcher\EventDispatcherInterface;
use Zorachka\Infrastructure\EventDispatcher\Recorder;

final class ReleaseRecordedEventsMiddleware implements Middleware
{
    private EventDispatcherInterface $dispatcher;
    private Recorder $recorder;

    public function __construct(EventDispatcherInterface $dispatcher, Recorder $recorder)
    {
        $this->dispatcher = $dispatcher;
        $this->recorder = $recorder;
    }

    /**
     * @inheritDoc
     */
    public function call(object $message, Context $context, callable $next): void
    {
        try {
            $next($message, $context);
        } catch (\Exception $exception) {
            $this->recorder->releaseEvents();

            throw $exception;
        }

        $recordedEvents = $this->recorder->releaseEvents();

        foreach ($recordedEvents as $event) {
            $this->dispatcher->dispatch($event);
        }
    }
}
