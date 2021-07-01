<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Database\Transaction;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use Doctrine\DBAL\Exception;
use Zorachka\Contracts\Application\Database\Transaction\Transaction;

final class DBALTransaction implements Transaction
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function begin(): void
    {
        $this->connection->beginTransaction();
    }

    /**
     * @throws ConnectionException|Exception
     */
    public function commit(): void
    {
        $this->connection->commit();
    }

    /**
     * @throws ConnectionException
     * @throws Exception
     */
    public function rollback(): void
    {
        $this->connection->rollBack();
    }
}
