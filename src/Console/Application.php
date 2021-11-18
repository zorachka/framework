<?php

declare(strict_types=1);

namespace Zorachka\Framework\Console;

interface Application
{
    /**
     * Run application.
     */
    public function run(): void;
}
