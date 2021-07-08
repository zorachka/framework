<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\CommandBus\Onliner\Middleware;

use Psr\Log\LoggerInterface;
use Throwable;
use Exception;
use Doctrine\DBAL\Connection;
use Onliner\CommandBus\Context;
use Onliner\CommandBus\Middleware;

final class TransactionMiddleware implements Middleware
{
    private Connection $connection;
    private LoggerInterface $logger;

    public function __construct(Connection $connection, LoggerInterface $logger)
    {
        $this->connection = $connection;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function call(object $message, Context $context, callable $next): void
    {
        $this->connection->beginTransaction();

        try {
            $next($message, $context);

            $this->connection->commit();
            $this->logger->debug('Transaction completed');
        } catch (Exception $exception) {
            $this->connection->rollBack();

            throw $exception;
        } catch (Throwable $exception) {
            $this->connection->rollBack();

            throw $exception;
        }
    }
}
