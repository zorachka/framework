<?php

declare(strict_types=1);

namespace Zorachka\Domain\EventDispatcher;

interface RecordEvents
{
    /**
     * Register that event was created.
     * @param object $event
     * @return void
     */
    public function registerThat(object $event): void;

    /**
     * Release array of events.
     * @return object[]
     */
    public function releaseEvents(): array;
}
