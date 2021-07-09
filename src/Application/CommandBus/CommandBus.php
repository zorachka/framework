<?php

declare(strict_types=1);

namespace Zorachka\Application\CommandBus;

interface CommandBus
{
    /**
     * Handle command.
     * @param object $command
     */
    public function handle(object $command): void;
}
