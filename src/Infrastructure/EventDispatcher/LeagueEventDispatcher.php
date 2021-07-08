<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\EventDispatcher;

use League\Event\EventDispatcher;
use Psr\EventDispatcher\EventDispatcherInterface;

final class LeagueEventDispatcher implements EventDispatcherInterface
{
    private EventDispatcher $dispatcher;

    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @inheritDoc
     */
    public function dispatch(object $event): object
    {
        return $this->dispatcher->dispatch($event);
    }
}
