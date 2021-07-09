<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\CommandBus\Onliner;

use Onliner\CommandBus\Dispatcher;
use Zorachka\Application\CommandBus\CommandBus;

final class OnlinerCommandBus implements CommandBus
{
    private Dispatcher $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function handle(object $command): void
    {
        $this->dispatcher->dispatch($command);
    }
}
