<?php

declare(strict_types=1);

namespace Zorachka\Framework\Console;

use Exception;
use Symfony\Component\Console\Application as SymfonyConsoleApplication;
use Symfony\Component\Console\Command\Command;

final class ConsoleApplication implements Application
{
    private SymfonyConsoleApplication $cli;

    /**
     * ConsoleApplication constructor.
     * @param string $appName
     * @param bool $catchExceptions
     * @param Command[] $commands
     */
    public function __construct(
        string $appName,
        bool $catchExceptions,
        array $commands = []
    ) {
        $this->cli = new SymfonyConsoleApplication($appName);

        $this->cli->setCatchExceptions($catchExceptions);

        if ($commands) {
            foreach ($commands as $command) {
                $this->cli->add($command);
            }
        }
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $this->cli->run();
    }
}
