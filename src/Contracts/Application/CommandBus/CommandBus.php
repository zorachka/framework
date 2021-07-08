<?php

declare(strict_types=1);

namespace Zorachka\Contracts\Application\CommandBus;

interface CommandBus
{
    public function handle(object $command): void;
}
