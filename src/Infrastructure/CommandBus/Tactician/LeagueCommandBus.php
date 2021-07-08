<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\CommandBus\Tactician;

use Zorachka\Contracts\Application\CommandBus\CommandBus;
use League\Tactician\CommandBus as TacticianCommandBus;

final class LeagueCommandBus implements CommandBus
{
    private TacticianCommandBus $commandBus;

    public function __construct(TacticianCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function handle(object $command): void
    {
        $this->commandBus->handle($command);
    }
}
