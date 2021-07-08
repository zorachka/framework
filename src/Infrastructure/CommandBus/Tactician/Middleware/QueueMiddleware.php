<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\CommandBus\Tactician\Middleware;

use League\Tactician\Middleware;

final class QueueMiddleware implements Middleware
{
    /**
     * @inheritDoc
     */
    public function execute($command, callable $next)
    {
        // TODO: Implement execute() method.
    }
}
