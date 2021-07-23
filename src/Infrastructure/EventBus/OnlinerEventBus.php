<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\EventBus;

use Onliner\CommandBus\Dispatcher;

final class OnlinerEventBus implements EventBus
{
    private Dispatcher $dispatcher;

    public function __construct(EventResolver $resolver)
    {
        $this->dispatcher = new Dispatcher($resolver);
    }

    public function dispatch(object $event): void
    {
        $this->dispatcher->dispatch($event);
    }
}
