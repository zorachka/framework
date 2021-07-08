<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\CommandBus\Onliner\Exception;

use Onliner\CommandBus\Exception\CommandBusException;

final class UnknownTransportException extends CommandBusException
{
    public function __construct(string $dsn)
    {
        parent::__construct(sprintf('Unknown transport: %s.', $dsn));
    }
}
