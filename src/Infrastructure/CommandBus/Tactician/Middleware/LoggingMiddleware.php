<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\CommandBus\Tactician\Middleware;

use League\Tactician\Middleware;
use Psr\Log\LoggerInterface;

final class LoggingMiddleware implements Middleware
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute($command, callable $next)
    {
        $commandClass = get_class($command);

        $this->logger->debug(\sprintf("Starting %s", $commandClass));
        $returnValue = $next($command);
        $this->logger->debug(\sprintf("%s finished without errors", $commandClass));

        return $returnValue;
    }
}
