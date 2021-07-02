<?php

declare(strict_types=1);

namespace Zorachka\Contracts\Console;

interface Application
{
    /**
     * Run console Application.
     */
    public function run(): void;
}
