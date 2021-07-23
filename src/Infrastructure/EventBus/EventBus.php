<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\EventBus;

interface EventBus
{
    public function dispatch(object $event): void;
}
