<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\EventBus;

use League\Event\PrioritizedListenerRegistry;
use Onliner\CommandBus\Resolver;

final class EventResolver implements Resolver
{
    private PrioritizedListenerRegistry $registry;

    public function __construct(PrioritizedListenerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @inheritDoc
     */
    public function resolve(object $command): callable
    {
        $callables = $this->registry->getListenersForEvent($command);

        foreach ($callables as $callable) {

        }
    }
}
