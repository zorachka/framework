<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\EventDispatcher;

final class Recorder
{
    /**
     * Array of events to dispatch.
     * @var object[]
     */
    private array $events = [];

    /**
     * Register events.
     * @param object[] $events
     * @return void
     */
    public function recordEvents(array $events)
    {
        $this->events = $events;
    }

    /**
     * Release array of events.
     * @return object[]
     */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
