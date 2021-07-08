<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\CommandBus\Onliner\Exception;

use Onliner\CommandBus\Exception\CommandBusException;

final class UnknownSerializerException extends CommandBusException
{
    public function __construct(string $type)
    {
        parent::__construct(sprintf('Unknown serializer: %s.', $type));
    }
}
