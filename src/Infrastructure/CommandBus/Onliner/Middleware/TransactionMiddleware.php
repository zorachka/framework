<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\CommandBus\Onliner\Middleware;

use Psr\Log\LoggerInterface;
use Throwable;
use Exception;
use Onliner\CommandBus\Context;
use Onliner\CommandBus\Middleware;
use Zorachka\Application\Database\Transaction\Transaction;

final class TransactionMiddleware implements Middleware
{
    private LoggerInterface $logger;
    private Transaction $transaction;

    public function __construct(Transaction $transaction, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->transaction = $transaction;
    }

    /**
     * @inheritDoc
     * @throws Exception
     * @throws Throwable
     */
    public function call(object $message, Context $context, callable $next): void
    {
        $this->transaction->begin();

        try {
            $next($message, $context);

            $this->transaction->commit();
            $this->logger->debug('Transaction completed');
        } catch (Exception $exception) {
            $this->transaction->rollBack();

            throw $exception;
        } catch (Throwable $exception) {
            $this->transaction->rollBack();

            throw $exception;
        }
    }
}
