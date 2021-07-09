<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Console;

interface Application
{
    /**
     * Run console ConsoleApplication.
     */
    public function run(): void;
}
