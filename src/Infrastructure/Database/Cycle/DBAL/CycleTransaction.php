<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Database\Cycle\DBAL;

use Spiral\Database\Database;
use Zorachka\Application\Database\Transaction\Transaction;

final class CycleTransaction implements Transaction
{
    private Database $manager;

    public function __construct(Database $database)
    {
        $this->manager = $database;
    }

    /**
     * @inheritDoc
     */
    public function begin(): void
    {
        $this->manager->begin();
    }

    /**
     * @inheritDoc
     */
    public function commit(): void
    {
        $this->manager->commit();
    }

    /**
     * @inheritDoc
     */
    public function rollback(): void
    {
        $this->manager->rollback();
    }
}
